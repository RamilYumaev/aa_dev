<?php
namespace backend\services\dictionary;



use backend\forms\dictionary\CategoryDocForm;
use backend\models\dictionary\CategoryDoc;
use backend\repositories\dictionary\CategoryDocRepository;

class CategoryDocService
{
    private $categoryDocRepository;

    public function __construct(CategoryDocRepository $categoryDocRepository)
    {
        $this->categoryDocRepository = $categoryDocRepository;
    }

    public function create(CategoryDocForm $form) {
        $catDoc = CategoryDoc::create($form->name, $form->type_id);
        $this->categoryDocRepository->save($catDoc);
        return $catDoc;
    }

    public function edit($id, CategoryDocForm $form) {
        $catDoc = $this->categoryDocRepository->get($id);
        $catDoc->edit($form->name, $form->type_id);
        $this->categoryDocRepository->save($catDoc);
    }

    public function remove($id) {
        $catDoc = $this->categoryDocRepository->get($id);
        $this->categoryDocRepository->remove($catDoc);
    }
}