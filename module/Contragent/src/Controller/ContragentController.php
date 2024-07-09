<?php
namespace Contragent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\{ViewModel, JsonModel};
use Contragent\Model\{Contragent, ContragentTable};
use Contragent\Form\ContragentForm;

class ContragentController extends AbstractActionController
{
    private $contragentTable;

    public function __construct(ContragentTable $contragentTable)
    {
        $this->contragentTable = $contragentTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'typeValue'   => Contragent::TYPE_VALUE,
            'contragents' => $this->contragentTable->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new ContragentForm();
        $form->get('submit')->setValue('Добавить');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $contragent = new Contragent();
            $form->setInputFilter($contragent->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $contragent->exchangeArray($form->getData());
                $this->contragentTable->saveContragent($contragent);

                // Redirect to list of contragents
                return $this->redirect()->toRoute('contragent');
            }
        }
        return ['form' => $form];
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('contragent');
        }
        $contragent = $this->contragentTable->getContragent($id);

        $form  = new ContragentForm();
        $form->get('submit')->setValue('Сохранить');
        $form->bind($contragent);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($contragent->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->contragentTable->saveContragent($form->getData());

                // Redirect to list of contragents
                return $this->redirect()->toRoute('contragent');
            }
        }

        return [
            'id'             => $id,
            'contragentName' => $contragent->value,
            'form'           => $form,
            'statusValue'    => Contragent::ADDRESS_DATA_QC_VALUE,
        ];
    }

    public function checkAction()
    {
        $hid = $this->params()->fromRoute('hid', 0);
        if (!$hid) {
            return new JsonModel(['success' => false]);
        }

        return new JsonModel(['success' => $this->contragentTable->isContragent($hid)]);
    }

    public function searchAction()
    {
        $contragentList[] = Contragent::DEFAULT_SEARCH_VALUE;
        $search = $this->params()->fromRoute('search', false);
        if (!$search) {
            return new JsonModel(['success' => $contragentList]);
        }
        $limit   = $this->params()->fromRoute('limit', 5);

        $results = $this->contragentTable->searchContragents($search, $limit);
        if (count($results)) {
            return new JsonModel(['success' => array_merge($contragentList, $results)]);
        } else {
            return new JsonModel(['success' => $contragentList]);
        }
    }
}