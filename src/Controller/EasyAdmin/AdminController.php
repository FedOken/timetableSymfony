<?php

namespace App\Controller\EasyAdmin;

use App\Controller\EasyAdmin\Handler\src\SelectDataHandler;
use App\Entity\User;
use App\Service\Access\AccessService;
use App\Service\Access\AdminAccess;
use App\Service\Access\FacultyAccess;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use App\Service\Access\UniversityAccess;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller\EasyAdmin
 *
 * @property User $user
 * @property EntityManagerInterface $em
 * @property AccessService $accessService
 * @property TranslatorInterface $translator
 * @property SelectDataHandler $selDataHandler
 */
class AdminController extends EasyAdminController
{
    protected $em;
    protected $accessService;
    protected $translator;
    protected $selDataHandler;

    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator, SelectDataHandler $selDataHandler, AccessService $accessService)
    {
        $this->em = $em;
        $this->accessService = $accessService;
        $this->selDataHandler = $selDataHandler;
        $this->translator = $translator;
    }

    /** @Route("/", name="easyadmin") */
    public function indexAction(Request $request)
    {
        if ($request->query->get('action')) {
            return parent::indexAction($request);
        }

        if ($this->isGranted(AdminAccess::getAccessRole())) {
            return $this->redirect('?action=list&entity=University');
        } elseif($this->isGranted(UniversityAccess::getAccessRole())) {
            return $this->redirect('?action=list&entity=University');
        } elseif($this->isGranted(FacultyAccess::getAccessRole())) {
            return $this->redirect('?action=list&entity=Faculty');
        } elseif($this->isGranted(PartyAccess::getAccessRole())) {
            return $this->redirect('?action=list&entity=Schedule');
        } elseif($this->isGranted(TeacherAccess::getAccessRole())) {
            return $this->redirect('?action=list&entity=Schedule');
        }
        return $this->redirect('/login');
    }

    /** @Route("/set-locale/{locale}", name="easyadmin-setLocale") */
    public function adminSetLocale(string $locale, Request $request)
    {
        if ($locale) {
            $request->getSession()->set('_locale', $locale);
        }
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @param array $validIds
     * @param string $entityName
     * @param array $grantedEditRole
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editCheckPermissionAndRedirect(array $validIds, string $entityName, array $grantedEditRole)
    {
        //Allow any edit for admin
        if ($this->isGranted(AdminAccess::getAccessRole())) {
            return parent::editAction();
        }

        if (!$validIds) {
            $this->addFlash('warning', $this->translator->trans('no_permission'));
            return $this->redirect($this->request->headers->get('referer'));
        }
        //For manager check id in url, redirect to valid url
        if ($this->isGranted($grantedEditRole)) {
            $id = $this->request->query->get('id');
            if(in_array($id, $validIds)) {
                return parent::editAction();
            }
            $this->addFlash('warning', $this->translator->trans('no_permission'));
            return $this->redirect('?action=edit&entity='.$entityName.'&id='.$validIds[0]);
        }

        //For other redirect to show view
        $this->addFlash('warning', $this->translator->trans('no_permission'));
        return $this->redirect('?action=show&entity='.$entityName.'&id='.$validIds[0]);
    }

    protected function listCheckPermissionAndRedirect(array $validIds, string $entityName, array $grantedEditRole)
    {
        if ($this->isGranted($grantedEditRole)) {
            return parent::listAction();
        } else {
            return $this->redirect('?action=show&entity='.$entityName.'&id='.$validIds[0]);
        }
    }

    protected function newCheckPermissionAndRedirect(array $validIds, string $entityName, array $grantedEditRole)
    {
        if ($this->isGranted($grantedEditRole)) {
            return parent::newAction();
        } else {
            return $this->redirect('?action=edit&entity='.$entityName.'&id='.$validIds[0]);
        }
    }
}
