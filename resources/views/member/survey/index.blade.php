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
            <div class="col-lg-8 offset-2">
                <div class="panel bg-cream" id="exampleWizardProgressbar">
                    <div class="panel-heading">
                        <div class="panel-actions panel-actions-keep">
                        <div class="progress progress-xs">
                            <div class="progress-bar active" style="width: 33.3%">
                            <span class="sr-only">1/3</span>
                            </div>
                        </div>
                        </div>
                        <h1 class="panel-title">Survey</h1>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{url('res/survey/'.base64_encode(auth()->user()->id))}}" enctype='multipart/form-data' id="surveyForm">
                        @csrf
                        @method('PUT')
                            <div class="wizard-content">
                                @foreach(monthlySurvey() as $key => $entry)
                                <div class="wizard-pane active p-4" role="tabpanel">
                                    <div class="row mt-4">
                                        <div class="col-lg-12">
                                            <div class="form-group form-material floating" data-plugin="formMaterial">
                                                <select class="form-control form-control-lg empty" name="answer[{{$entry->id}}]" required>
                                                    <option value=""></option>
                                                    @foreach($entry->answer as $i => $answer)
                                                    <option value="{{$answer}}">{{$answer}}</option>
                                                    @endforeach
                                                </select>
                                                <label class="floating-label">{{$entry->question}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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

<script src="{{asset('app/classic/global/vendor/formvalidation/formValidation.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="{{asset('app/classic/global/vendor/jquery-wizard/jquery-wizard.js')}}"></script>
<script src="{{asset('app/classic/global/js/Plugin/jquery-wizard.js')}}"></script>
<script src="{{asset('app/classic/global/js/Plugin/icheck.js')}}"></script>
<script src="{{asset('assets/js/survey-questionaire.js')}}"></script>
</html>