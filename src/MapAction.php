<?php

namespace sergey144010\users;


use Aura\Router\Map;
use Aura\Router\Route;
use sergey144010\users\Action\Edit;
use sergey144010\users\Action\GetUser;
use sergey144010\users\Action\Index;
use sergey144010\users\Action\NewUser;
use sergey144010\users\Action\Remove;
use sergey144010\users\Action\Save;
use sergey144010\users\Action\Update;
use Zend\Diactoros\ServerRequest;

class MapAction
{
    private $map;
    /**
     * @var ServerRequest $request
     */
    private $request;

    public function __construct(Map $map)
    {
        $this->map = $map;
    }

    public function init()
    {
        $this->index();
        $this->newUser();
        $this->save();
        $this->remove();
        $this->edit();
        $this->update();
        $this->get();
    }

    /**
     * @param ServerRequest $request
     * @return $this
     */
    public function withRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function index()
    {
        $path = $this->request->getUri()->getPath();
		if($path == '/'){
            $route = new Route();
            $route->name('user.index');
            $route->path($path);
            $route->handler(Index::class);
            $this->map->addRoute($route);
        }
    }

    public function newUser()
    {
        $this->map->get('user.new', '/new', NewUser::class);
    }

    public function save()
    {
        $this->map->post('user.save', '/save', Save::class);
    }

    public function remove()
    {
        $this->map->get('user.remove', '/remove/{id}', Remove::class)
            ->tokens(['id' => function($uuid){
                if(preg_match('/^\d+$/i', $uuid)) {
                    return true;
                }else{
                    return false;
                }
        }]);
    }

    public function edit()
    {
        $this->map->get('user.edit', '/edit/{id}', Edit::class)
            ->tokens(['id' => function($uuid){
                if(preg_match('/^\d+$/i', $uuid)) {
                    return true;
                }else{
                    return false;
                }
            }]);
    }

    public function update()
    {
        $this->map->post('user.update', '/update', Update::class);
    }

    public function get()
    {
        $this->map->get('user.get', '/user/{id}', GetUser::class)
            ->tokens(['id' => function($id){
                if(preg_match('/^\d+$/i', $id)) {
                    return true;
                }else{
                    return false;
                }
        }]);
    }
}