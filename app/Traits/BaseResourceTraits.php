<?php

namespace App\Traits;
use Illuminate\Container\Container as Application;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait BaseResourceTraits
{
     /**
    * @var Application
    */
   protected $app;

   /**
    * @param Application $app
    *
    * @throws \Exception
    */
   public function __construct(Application $app)
   {
       $this->app = $app;
       $this->makeRepository();
   }
   /**
    * @var BaseRepository
    */
   protected $modelRepository;
   public abstract function repository();
   protected function makeRepository()
   {
       $modelRepository = $this->app->make($this->repository());

       if (!$modelRepository instanceof BaseRepository) {
           throw new \Exception("Class {$this->repository()} must be an instance of App\Repositories\BaseRepository");
       }

       return $this->modelRepository = $modelRepository;
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
       return $this->JsonOK($this->modelRepository->search($request));
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $input = $request->input();
       $validator = $this->modelRepository->validator($input, null);
       if ($validator->fails())
           return $this->JsonErrors($validator->messages());
       $this->storeBefore($request, $input);
       $rs = $this->modelRepository->create($input);
       $this->storeAfter($request, $input, $rs);
       return $this->JsonOK($rs);
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       return $this->JsonOK($this->modelRepository->find($id));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
       $input = $request->input();
       $validator = $this->modelRepository->validator($input, $id);
       if ($validator->fails())
           return $this->JsonErrors($validator->messages());
       $this->updateBefore($request, $id, $input);
       $rs = $this->modelRepository->update($input, $id);
       $this->updateAfter($request, $id, $input, $rs);
       return $this->JsonOK($rs);
   }


   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, $id)
   {
       $this->destroyBefore($request, $id);
       $rs = $this->modelRepository->delete($id);
       $this->destroyAfter($request, $id, $rs);
       return $this->JsonOK($rs);
   }
    /**
     * Store before a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $input
     * @return void
     */
    protected function storeBefore(Request $request, $input)
    {
    }
    /**
     * Store after a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $input
     * @param  object  $model
     * @return void
     */
    protected function storeAfter(Request $request, $input, $model)
    {
    }
    /**
     * Update before the specifiedd resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  array  $input
     * @return void
     */
    protected function updateBefore(Request $request, $id, $input)
    {
    }
    /**
     * Update after the specifiedd resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  array  $input
     * @param  object  $model
     * @return void
     */
    protected function updateAfter(Request $request, $id, $input, $model)
    {
    }

    /**
     * Remove before the specifiedd resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return void
     */
    protected function destroyBefore(Request $request, $id)
    {
    }
    /**
     * Remove after the specifiedd resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  object  $model
     * @return void
     */
    protected function destroyAfter(Request $request, $id, $model)
    {
    }
}
