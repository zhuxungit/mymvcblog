<?php
namespace Controller\Admin;

class ProductsController extends \Controller\Admin\BaseController
{
    public function insertAction()
    {

        $data['proname']= 'aa';
        $data['proguige'] = 'bb';
        $productsModel = new \Model\ProductsModel;
        $test = $productsModel->inserttestp($data);
        var_dump($test);
    }
    public function updateAction()
    {
        $data['proname']= '111';
        $data['proguige'] = '222';
        $data['proID'] = 76;

        $productsModel = new \Model\ProductsModel;
        $test = $productsModel->updatetestp($data);
        var_dump($test);
    }
    public function selectAction()
    {
        $productsModel = new \Model\ProductsModel;
        $test = $productsModel->seletetestp();
        var_dump($test);
    }
    public function findAction()
    {
        $id = 76;
        $productsModel = new \Model\ProductsModel;
        $test = $productsModel->findtestp($id);
        var_dump($test);
    }
}