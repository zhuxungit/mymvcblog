<?php
namespace Model;

class ProductsModel extends \Core\Model
{
    public function inserttestp($data)
    {
        return $this->inserttest($data);
    }
    public function updatetestp($data)
    {
        return $this->updatetest($data);
    }
    public function seletetestp()
    {
        return $this->seletetest();
    }
    public function findtestp($id)
    {
        return $this->findtest($id);
    }
}