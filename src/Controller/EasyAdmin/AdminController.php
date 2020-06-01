<?php

namespace App\Controller\EasyAdmin;

use App\Handler\UniversityHandler;
use App\Helper\ArrayHelper;
use App\Service\Access\AccessService;
use App\Service\Access\AdminAccess;
use App\Service\Access\FacultyAccess;
use App\Service\Access\PartyAccess;
use App\Service\Access\TeacherAccess;
use App\Service\Access\UniversityAccess;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminControllerTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\NoPermissionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends EasyAdminController
{

    protected $accessService;
    protected $translator;
    protected $universityHandler;

    public function __construct(TranslatorInterface $translator, UniversityHandler $universityHandler, AccessService $accessService)
    {
        //Access service
        $this->accessService = $accessService;
        //Handler
        $this->universityHandler = $universityHandler;
        //Translator
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

    /**
     * @param array $validIds
     * @param string $entityName
     * @param string $grantedEditRole
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function editCheckPermissionAndRedirect(array $validIds, string $entityName, string $grantedEditRole)
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

    /**
     * @param array $validIds
     * @param string $entityName
     * @param string $grantedEditRole
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function listCheckPermissionAndRedirect(array $validIds, string $entityName, string $grantedEditRole)
    {
        if ($this->isGranted($grantedEditRole)) {
            return parent::listAction();
        } else {
            return $this->redirect('?action=show&entity='.$entityName.'&id='.$validIds[0]);
        }
    }
}
