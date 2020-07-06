<?php
namespace App\Command;

use App\Entity\SendGridTemplate;
use App\Helper\ArrayHelper;
use App\Repository\SendGridTemplateRepository;
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
class SendGridUpdateTemplates extends Command
{
    protected static $defaultName = 'app:send-grid-update-templates';

    private $em;

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        $this->em = $em;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Update send grid templates');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $sg = new \SendGrid(SendGridTemplate::API_KEY);

        $query_params = [
            'generations' => 'dynamic',
            'page_size' => 200
        ];
        $response = $sg->client->templates()->get(null, $query_params);

        $inputData = ArrayHelper::getValue(json_decode($response->body()), 'result');

        if (!$inputData) return;

        /** @var SendGridTemplateRepository $repo */
        $repo = $this->em->getRepository(SendGridTemplate::class);

        foreach ($inputData as $data) {
            echo "Updated - {$data->name}\n";
            $model = $repo->findOneBy(['template_id' => $data->id]) ?: new SendGridTemplate();
            $model->template_id = $data->id;
            $model->name = $data->name;
            $model->slug = strtolower(str_replace(' ', '-', $data->name));

            $this->em->persist($model);
            $this->em->flush();
        }

        $inputTemplateIds = ArrayHelper::getColumn($inputData, 'id');
        $tempToDel = $repo->findAllExceptIds($inputTemplateIds);
        foreach ($tempToDel as $model) {
            echo "Deleted - {$model->slug}\n";
            $this->em->remove($model);
        }
        $this->em->flush();
        echo 'Complete';
    }
}
