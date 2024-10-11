<?php

namespace Dev\Location\Http\Controllers;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Http\Actions\DeleteResourceAction;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Supports\Breadcrumb;
use Dev\Location\Forms\CountryForm;
use Dev\Location\Http\Requests\CountryRequest;
use Dev\Location\Http\Resources\CountryResource;
use Dev\Location\Models\Country;
use Dev\Location\Tables\CountryTable;
use Illuminate\Http\Request;

class CountryController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/location::location.name'))
            ->add(trans('plugins/location::country.name'), route('country.index'));
    }

    public function index(CountryTable $table)
    {
        $this->pageTitle(trans('plugins/location::country.name'));

        return $table->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('plugins/location::country.create'));

        return CountryForm::create()->renderForm();
    }

    public function store(CountryRequest $request)
    {
        $form = CountryForm::create()->setRequest($request);
        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('country.index')
            ->setNextRoute('country.edit', $form->getModel()->getKey())
            ->withCreatedSuccessMessage();
    }

    public function edit(Country $country)
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $country->name]));

        return CountryForm::createFromModel($country)->renderForm();
    }

    public function update(Country $country, CountryRequest $request)
    {
        CountryForm::createFromModel($country)->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('country.index')
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Country $country)
    {
        return DeleteResourceAction::make($country);
    }

    public function getList(Request $request)
    {
        $keyword = BaseHelper::stringify($request->input('q'));

        if (! $keyword) {
            return $this
                ->httpResponse()
                ->setData([]);
        }

        $data = Country::query()
            ->where('name', 'LIKE', '%' . $keyword . '%')
            ->select(['id', 'name'])
            ->take(10)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $data->prepend(new Country(['id' => 0, 'name' => trans('plugins/location::city.select_country')]));

        return $this
            ->httpResponse()
            ->setData(CountryResource::collection($data));
    }
}
