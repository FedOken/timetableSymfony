<?php

namespace App\Controller\API\Handler;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;

class TeacherHandler extends BaseHandler
{
    /**
     * Return teachers for selected university
     * @param int $unId
     * @return array
     */
    public function getTeachersByUniversity(int $unId): array
    {
        try {
            /**@var TeacherRepository $repo */
            $repo = $this->em->getRepository(Teacher::class);
            $models = $repo->findByUniversities([$unId]);

            $data = [];
            /**@var Teacher $model */
            foreach ($models as $model) {
                $data[] = [
                    'id' => $model->id,
                    'unId' => $unId,
                    'name' => $model->name,
                    'nameFull' => $model->name_full,
                    'position' => $model->position,
                ];
            }
            return [
                'status' => true,
                'data' => $data,
                'unId' => $unId
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Return autocomplete result
     * @param string $query
     * @return array
     */
    public function getTeachersByName(string $query): array
    {
        try {
            $query = trim($query);
            if (!$query) return [];

            /**@var TeacherRepository $repo */
            $repo = $this->em->getRepository(Teacher::class);
            $models = $repo->findByName($query);

            $data = [];
            /**@var Teacher $model*/
            foreach ($models as $model) {
                $data[] = ['value' => $model->id, 'label' => $model->name];
            }
            return [
                'status' => true,
                'data' => $data,
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}