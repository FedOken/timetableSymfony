<?php
namespace App\Command;

use App\Entity\Building;
use App\Entity\Cabinet;
use App\Entity\Course;
use App\Entity\Faculty;
use App\Entity\Party;
use App\Entity\Schedule;
use App\Entity\Teacher;
use App\Entity\UniversityTime;
use App\Entity\Week;
use App\Repository\CabinetRepository;
use App\Repository\PartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsoleCommand
 * @package App\Command
 *
 * @property EntityManagerInterface $em
 */
class ClearRelationCommand extends Command
{
    protected static $defaultName = 'app:clear-relations';

    private $em;

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        $this->em = $em;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Delete all models without relations');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->clearUniversityRelation(Faculty::class, 'faculties');
        $this->clearUniversityRelation(Building::class, 'buildings');
        $this->clearUniversityRelation(Course::class, 'courses');
        $this->clearUniversityRelation(Week::class, 'weeks');
        $this->clearUniversityRelation(UniversityTime::class, 'university times');
        $this->clearUniversityRelation(Teacher::class, 'teachers');
        $this->clearParties();
        $this->clearCabinets();
        $this->clearSchedules();

        echo 'Completed';
    }

    private function clearParties()
    {
        /** @var PartyRepository $repo */
        $repo = $this->em->getRepository(Party::class);
        $countModelToDel = 0;
        foreach ($repo->findAll() as $model) {
            if (!$model->faculty) {
                $this->em->remove($model);
                $this->em->flush();
                $countModelToDel++;
            };
        }
        echo "Count of removed parties - {$countModelToDel};\n";
    }

    private function clearSchedules()
    {
        /** @var ScheduleRepository $repo */
        $repo = $this->em->getRepository(Schedule::class);
        $countModelToDel = 0;
        foreach ($repo->findAll() as $model) {
            if (!$model->party ||
                !$model->lesson_type ||
                !$model->teacher ||
                !$model->cabinet ||
                !$model->week ||
                !$model->day ||
                !$model->universityTime) {
                $this->em->remove($model);
                $this->em->flush();
                $countModelToDel++;
            };
        }
        echo "Count of removed schedules - {$countModelToDel};\n";
    }

    private function clearCabinets()
    {
        /** @var CabinetRepository $repo */
        $repo = $this->em->getRepository(Cabinet::class);
        $countModelToDel = 0;
        foreach ($repo->findAll() as $model) {
            if (!$model->building) {
                $this->em->remove($model);
                $this->em->flush();
                $countModelToDel++;
            };
        }
        echo "Count of removed cabinets - {$countModelToDel};\n";
    }

    private function clearUniversityRelation($repoClass, $label)
    {
        $repo = $this->em->getRepository($repoClass);
        $countModelToDel = 0;
        foreach ($repo->findAll() as $model) {
            if (!$model->university) {
                $this->em->remove($model);
                $this->em->flush();
                $countModelToDel++;
            };
        }
        echo "Count of removed {$label} - {$countModelToDel};\n";
    }
}
