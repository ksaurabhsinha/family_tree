<?php
namespace App\Repositories\Infrastructure\Contracts;
use App\Repositories\Infrastructure\Exceptions\RepositoryException;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
abstract class AbstractRepository implements RepositoryInterface
{
    /** @var \Illuminate\Container\Container */
    private $app;
    /** @var  \Illuminate\Database\Eloquent\Model */
    protected $model;
    /**
     * @return string
     */
    abstract function getModel(): string;
    /**
     * @param \Illuminate\Container\Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->makeModel();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Model|mixed
     *
     * @throws \App\Repositories\Infrastructure\Exceptions\RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->getModel());
        if (!$model instanceof Model) {
            throw new RepositoryException("{$this->getModel()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }
    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function all(array $columns = ['*'])
    {
        return $this->model->get($columns);
    }
    /**
     * @param int   $perPage
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($perPage = 15, array $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }
    /**
     * @param        $data
     * @param        $id
     * @param string $attribute
     *
     * @return mixed
     */
    public function update($data, $id, $attribute = "id")
    {
        return $this->model->where($attribute, '=', $id)->update($data);
    }
    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
    /**
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }
    /**
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findBy($field, $value, array $columns = ['*'])
    {
        return $this->model->where($field, '=', $value)->first($columns);
    }
}