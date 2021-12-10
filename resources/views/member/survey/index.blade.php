<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        
    <link rel="apple-touch-icon" href="{{asset('app/classic/base/assets/images/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/iwellness_logo.png')}}">
  
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('app/classic/global/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/css/bootstrap-extend.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/base/assets/css/site.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/jquery-wizard/jquery-wizard.css')}}">
    <link rel="stylesheet" href="{{asset('app/material/global/vendor/formvalidation/formValidation.css')}}">
    <link rel="stylesheet" href="{{asset('app/classic/global/vendor/icheck/icheck.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/custom-admin.css')}}">
    
    <title>Survey</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 px-10 mb-4 d-flex justify-content-center">
                <img src="{{asset('assets/images/iwellness_logo_text.png')}}" width="20%" class="m-auto" alt="">
            </div>
            <div class="col-lg-8 col-md-12 offset-lg-2">
                <div class="panel bg-cream">
                    <div class="panel-heading">
                        <h1 class="panel-title">Survey</h1>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{url('res/survey/'.base64_encode(auth()->user()->id))}}" enctype='multipart/form-data' id="surveyForm">
                        @csrf
                        @method('PUT')
                            <input type="hidden" name="key" value="{{monthlySurvey()['key']}}">
                            <input type="hidden" name="subs_id" value="{{monthlySurvey()['subs_id']}}">
                            <input type="hidden" name="type" value="{{monthlySurvey()['type']}}">
                            <div class="row">
                                @php
                                    $fields = [];
                                @endphp
                                
                                @foreach(monthlySurvey()['survey'] as $key => $entry)
                                    <div class="col-lg-12 pb-2 mb-10">
                                        <h3 class="mb-4">{{$key+1}}. {{ $entry->question }}</h3>

                                        @foreach($entry->answer as $i => $answer)
                                            <div class="form-group">
                                                <input type="checkbox" data-plugin="iCheck" data-checkbox-class="icheckbox_flat-orange" class="mr-2 icheckbox-orange" name="answer[{{$entry->id}}][]" value="{{ $answer }}">
                                                <label for="">{{ $answer }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @php $fields[] = 'answer['.$entry->id.'][]' @endphp
                                @endforeach
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-outline btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{asset('app/classic/global/vendor/babel-external-helpers/babel-external-helpers.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/jquery/jquery.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/popper-js/umd/popper.min.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/bootstrap/bootstrap.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/animsition/animsition.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/asscrollbar/jquery-asScrollbar.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/asscrollable/jquery-asScrollable.js')}}"></script>
<script src="{{asset('app/classic/global/vendor/ashoverscroll/jquery-asHoverScroll.js')}}"></script>
<script src="{{asset('app/material/global/vendor/jquery-mmenu/jquery.mmenu.min.all.js')}}"></script>
<script src="{{asset('app/material/global/vendor/waves/waves.js')}}"></script>

<script src="{{asset('app/classic/global/js/Component.js')}}"></script>
<script src="{{asset('app/classic/global/js/Plugin.js')}}"></script>
<script src="{{asset('app/classic/global/js/Base.js')}}"></script>
<script src="{{asset('app/classic/global/js/Config.js')}}"></script>
<script src="{{asset('app/classic/base/assets/js/Site.js')}}"></script>
<script src="{{asset('app/classic/base/assets/js/Section/Menubar.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="{{asset('app/classic/global/vendor/jquery-wizard/jquery-wizard.js')}}"></script>
<script src="{{asset('app/classic/global/js/Plugin/jquery-wizard.js')}}"></script>
<script src="{{asset('app/classic/global/js/Plugin/icheck.js')}}"></script>
<script>
    window.fields = {!! json_encode($fields) !!}
</script>
<script src="{{asset('assets/js/survey-questionaire.js')}}"></script>
</html>