@extends('layouts.contentLayoutMaster')
{{-- title --}}

@if($setting->language == 1)

  @if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == ('fr' || 'en'))

    @section('title','Année scolaire')

  @endif

@else

  @section('title','School year')

@endif


{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/wizard.css')}}">
@endsection

@section('content')


@if($setting->language == 1)

  @if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == ('fr' || 'en'))

          <!-- header breadcrumbs -->
          <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
              <div class="row breadcrumbs-top">
                <div class="col-12">
                  <h5 class="content-header-title float-left pr-1 mb-0">Accueil</h5>
                  <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                                              <li class="breadcrumb-item ">
                                      <a href="#"><i class="bx bx-home-alt"></i></a>
                                      </li>
                                    <li class="breadcrumb-item active">
                                    Année scolaire
                                      </li>
                  </div>
                </div>
              </div>
            </div>
          </div>


    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">

      <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Année scolaire</h3>
                </div>
            </div>
            <form class="new-added-form" action="{{route('schoolsyear-update', $schoolyear->id)}}" method="POST">

              @csrf
              {{method_field('PUT')}}

                <input type="hidden" class="form-control" value="{{$school->id}}" name="school" required>

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                        <label>Periode actuel</label>

                        <input type="hidden" class="form-control" value="{{$schoolyear->year}}" name="year" aria-describedby="exampleAddon" required>

                        <input type="text" class="form-control" readonly value="{{date('Y', strtotime($schoolyear->year))}} / {{date('Y', strtotime($schoolyear->year . ' + 1 years'))}}" aria-describedby="exampleAddon">

                    </div>
                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                        <label>Date de début </label>
                          <input type="date" class="form-control" id="exampleInput" value="{{$schoolyear->start_date}}" name="start_date" min="{{$schoolyear->year}}" placeholder="Example input placeholder" required>

                          @if(session()->get('scolar1'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              La date de début saisie est plus grande que la date de fin.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                          @endif

                    </div>
                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                        <label>Date de fin </label>
                          <input type="date" class="form-control" id="exampleInput" value="{{$schoolyear->end_date}}" name="end_date" min="{{$schoolyear->year}}"  placeholder="Example input placeholder" required>


                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <button type="reset" class="btn btn-light">Effacer</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

    </section>
    <!-- // Basic multiple Column Form section end -->

  @endif

@else

<!-- header breadcrumbs -->
          <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
              <div class="row breadcrumbs-top">
                <div class="col-12">
                  <h5 class="content-header-title float-left pr-1 mb-0">Home</h5>
                  <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                                              <li class="breadcrumb-item ">
                                      <a href="#"><i class="bx bx-home-alt"></i></a>
                                      </li>
                                    <li class="breadcrumb-item active">
                                    School year
                                      </li>
                  </div>
                </div>
              </div>
            </div>
          </div>


    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">

      <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>School year</h3>
                </div>
            </div>
            <form class="new-added-form" action="{{route('schoolsyear-update', $schoolyear->id)}}" method="POST">

              @csrf
              {{method_field('PUT')}}

                <input type="hidden" class="form-control" value="{{$school->id}}" name="school" required>

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                        <label>Current period</label>

                        <input type="hidden" class="form-control" value="{{$schoolyear->year}}" name="year" aria-describedby="exampleAddon" required>

                        <input type="text" class="form-control" readonly value="{{date('Y', strtotime($schoolyear->year))}} / {{date('Y', strtotime(date('Y', strtotime($schoolyear->year)) . ' + 1 years'))}}" aria-describedby="exampleAddon">

                    </div>
                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                        <label>Start date </label>
                          <input type="date" class="form-control" id="exampleInput" value="{{$schoolyear->start_date}}" name="start_date" min="{{$schoolyear->year}}" placeholder="Example input placeholder" required>

                          @if(session()->get('scolar1'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              The written start date is higher than the end date
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                          @endif

                    </div>
                    <div class="col-xl-4 col-lg-4 col-12 form-group">
                        <label>End date </label>
                          <input type="date" class="form-control" id="exampleInput" value="{{$schoolyear->end_date}}" name="end_date" min="{{$schoolyear->year}}"  placeholder="Example input placeholder" required>


                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-light">Restore</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

    </section>
    <!-- // Basic multiple Column Form section end -->

@endif


@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/forms/wizard-steps.js')}}"></script>
{{-- supermask.js cdn--}}
<script src="https://cdn.jsdelivr.net/npm/supermask-js@1.0.0/index.min.js"></script>
@endsection
