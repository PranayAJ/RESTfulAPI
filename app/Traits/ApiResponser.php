<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;



trait ApiResponser{
    private function successResponse($data , $code)
    {
        return response()->json($data , $code);
    }
    protected function errorResponse($message , $code){
        return response()->json(['error'=>$message, 'code'=>$code],$code);
    }
    protected function showAll(Collection $collection, $code=200 ){
        if($collection->isEmpty()){
            return $this->successResponse(['data'=>$collection], $code);
        }

        $transformer = $collection->first()->transformer;
        $collection = $this->filterData($collection, $transformer);
        $collectiom = $this->sort($collection, $transformer);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        return $this->successResponse($collection, $code);
    }
    protected function showOne(Model $model, $code=200){
        $transformer = $model->transformer;
        $model = $this->transformData($model, $transformer);
        return $this->successResponse($model,200);
    }
    protected function showMessage($message, $code=200)
    {
        return $this->successResponse(['data' => $message], $code);
    }
    protected function transformData($data , $transformer){
        $transformation = fractal($data , new $transformer);
        return $transformation->toArray();
    }
    public function sort(Collection $collection, $transformer){
        if(request()->has('sort_by')){
            $transformedAttribute = request()->sort_by;
            $sortAttribute = $transformer::attributeMapper($transformedAttribute);
            $collection = $collection->sortBy($sortAttribute);
        }
        return $collection;
        }
        public function filterData(Collection $collection, $transformer){
            foreach(request()->query() as $query=>$value){
                $actualAttribute = $transformer::attributeMapper($query);
                if(asset($actualAttribute,$value)){
                    $collection = $collection->where($actualAttribute, $value);
                }
            }
            return $collection;
        }
        public function paginate(Collection $collection){
            $page = LengthAwarePaginator::ResolveCurrentPage();
            $elementsPerPage = 15;
            $results = $collection->slice($elementPerPage*($page-1),$elementsPerPage)->values;
        }
    }
