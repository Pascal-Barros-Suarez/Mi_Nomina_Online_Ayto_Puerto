<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PayrollRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PayrollCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PayrollCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Payroll::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payroll');
        CRUD::setEntityNameStrings('payroll', 'payrolls');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('user_id');
        CRUD::column('gross_salary');
        CRUD::column('base_salary');
        CRUD::column('income_tax');
        CRUD::column('destination_allowance');
        CRUD::column('specific_allowance');
        CRUD::column('concept');
        CRUD::column('specific_complement');
        CRUD::column('commission_attendance');
        CRUD::column('common_contingencies');
        CRUD::column('unemployment');
        CRUD::column('mei');
        CRUD::column('professional_training');
        CRUD::column('csic');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PayrollRequest::class);

        CRUD::field('user_id');
        CRUD::field('gross_salary');
        CRUD::field('base_salary');
        CRUD::field('income_tax');
        CRUD::field('destination_allowance');
        CRUD::field('specific_allowance');
        CRUD::field('concept');
        CRUD::field('specific_complement');
        CRUD::field('commission_attendance');
        CRUD::field('common_contingencies');
        CRUD::field('unemployment');
        CRUD::field('mei');
        CRUD::field('professional_training');
        CRUD::field('csic');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
