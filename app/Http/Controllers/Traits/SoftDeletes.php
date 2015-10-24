<?php namespace Admin\Http\Controllers\Traits;
 
trait SoftDeletes 
{
    public function delete($id)
    {
        $model = $this->model($id);

        if ($model->id) {
            $model->delete();
        } else {
            $this->errors[] = 'Not Model';
        }
        
        return $this->result();
    }    
    
    public function restore($id)
    {
        $modelName = $this->getModelClass();
        $model = $modelName::withTrashed()->findOrFail($id);

        if ($model->id) {
            $model->restore();
        } else {
            $this->errors[] = 'Not Model';
        }
        
        return $this->result();
    }
    
    public function destroy($id)
    {
        $modelName = $this->getModelClass();
        $model = $modelName::withTrashed()->findOrFail($id);

        if ($model->id) {
            $model->forceDelete();
        } else {
            $this->errors[] = 'Not Model';
        }
        
        return $this->result();
    }    
}
