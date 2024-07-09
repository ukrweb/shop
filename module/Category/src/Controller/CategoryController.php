<?php
namespace Category\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\{ViewModel, JsonModel};
use Category\Model\{
    Category,
    CategoryTable,
    SupplierCategory,
    SupplierCategoryTable,
    OsCategoryDescription,
    OsCategoryDescriptionTable
};
use Category\Form\CategoryForm;

class CategoryController extends AbstractActionController
{
    private $categoryTable;
    private $supplierCategoryTable;
    private $osCategoryDescriptionTable;

    public function __construct(
        CategoryTable $categoryTable,
        SupplierCategoryTable $supplierCategoryTable,
        OsCategoryDescriptionTable $osCategoryDescriptionTable
    ) {
        $this->categoryTable              = $categoryTable;
        $this->supplierCategoryTable      = $supplierCategoryTable;
        $this->osCategoryDescriptionTable = $osCategoryDescriptionTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'typeValue'  => Category::STATUS_VALUE,
            'categories' => $this->categoryTable->getCategoriesArray(),
        ]);
    }

    public function addAction()
    {
        $form = new CategoryForm();
        // defaultParentСategoryOptions
        $form->get('category_parent_id')->setValueOptions(
            $this->categoryTable->defaultCategoryParentOptions(false)
        );
        // defaultOSСategoryOptions
        $form->get('oc_category_id')->setValueOptions(
            $this->osCategoryDescriptionTable->defaultOcCategoryOptions(false)
        );
        $form->remove('supplier_category');
        $form->get('submit')->setValue('Добавить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $category = new Category();
            // selectedParentСategoryOptions
            $form->get('category_parent_id')->setValueOptions(
                $this->categoryTable->defaultCategoryParentOptions($request->getPost('category_parent_id'))
            );
            // selectedOSСategoryOptions
            $form->get('oc_category_id')->setValueOptions(
                $this->osCategoryDescriptionTable->defaultOcCategoryOptions($request->getPost('oc_category_id'))
            );
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $category->exchangeArray($form->getData());
                $this->categoryTable->saveCategory($category);

                // Redirect to list of categories
                return $this->redirect()->toRoute('category');
            }
        }
        return ['form' => $form];
    }

    public function editAction()
    {
        $category_id = (int) $this->params()->fromRoute('category_id', 0);
        if (!$category_id) {
            return $this->redirect()->toRoute('category');
        }
        $category = $this->categoryTable->getCategory($category_id);

        $form  = new CategoryForm();
        // defaultParentСategoryOptions
        $form->get('category_parent_id')->setValueOptions(
            $this->categoryTable->defaultCategoryParentOptions($category->category_parent_id)
        );
        // defaultOSСategoryOptions
        $form->get('oc_category_id')->setValueOptions(
            $this->osCategoryDescriptionTable->defaultOcCategoryOptions($category->oc_category_id)
        );
        // supplierСategories
        $supplierCategories = $this->supplierCategoryTable->getSupplierCategoriesArray($category_id);
        // supplierСategory
        if (count($supplierCategories)) {
            $form->get('supplier_category')->setValueOptions(
                $this->categoryTable->defaultCategoryParentOptions(false)
            );
        } else {
            $form->remove('supplier_category');
        }
        $form->get('submit')->setValue('Сохранить');
        $form->bind($category);

        $request = $this->getRequest();
        if ($request->isPost()) {
            // selectedParentСategoryOptions
            $form->get('category_parent_id')->setValueOptions(
                $this->categoryTable->defaultCategoryParentOptions($request->getPost('category_parent_id'))
            );
            // selectedOSСategoryOptions
            $form->get('oc_category_id')->setValueOptions(
                $this->osCategoryDescriptionTable->defaultOcCategoryOptions($request->getPost('oc_category_id'))
            );
//             var_dump($form->get('category_parent_id')->getValueOptions());
//             var_dump($form->get('oc_category_id')->getValueOptions());
//             die();
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->categoryTable->updateChildCategory($category_id);
                $this->categoryTable->saveCategory($form->getData());
                $this->supplierCategoryTable->saveSupplierCategories($request->getPost());

                // Redirect to list of categories
                return $this->redirect()->toRoute('category');
            }
        }

        return [
            'category_id'         => $category_id,
            'categoryName'        => $category->category_name,
            'form'                => $form,
            'supplierCategories'  => $supplierCategories,
            'statusValue'         => Category::STATUS_VALUE,
            'categoryEnableValue' => Category::CATEGORY_ENABLE_VALUE,
        ];
    }

    public function searchAction()
    {
        $categoryList[] = Category::DEFAULT_SEARCH_VALUE;
        $search = $this->params()->fromRoute('search', false);
        if (!$search) {
            return new JsonModel(['success' => $categoryList]);
        }
        $excludeCategoryId = $this->params()->fromRoute('category_id', 0);
        $limit = $this->params()->fromRoute('limit', 5);

        $results = $this->categoryTable->searchCategories($search, $excludeCategoryId, $limit);
        if (count($results)) {
            return new JsonModel(['success' => array_merge($categoryList, $results)]);
        } else {
            return new JsonModel(['success' => $categoryList]);
        }
    }

    public function osCategoriesSearchAction()
    {
        $osCategoryList[] = Category::DEFAULT_SEARCH_VALUE;
        $search = $this->params()->fromRoute('search', false);
        if (!$search) {
            return new JsonModel(['success' => $osCategoryList]);
        }
        $limit = $this->params()->fromRoute('limit', 5);

        $results = $this->osCategoryDescriptionTable->searchOsCategoriesDescription($search, $limit);
        if (count($results)) {
            return new JsonModel(['success' => array_merge($osCategoryList, $results)]);
        } else {
            return new JsonModel(['success' => $osCategoryList]);
        }
    }
}