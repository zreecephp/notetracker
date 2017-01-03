@extends('layouts.app')

@section('content')
<div class="container" style = "background-color: grey;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} You are logged in!
                    <a href="{{ url('/logout') }}">Sign Out</a>
                </div>
				

				
				
				
				
				
				
								@if ($errors->any())
									<section class="error-box">
										<ul>
											@foreach ($errors->all() as $error)
												<li> {{ $error }}</li>
											@endforeach
										</ul>
									</section>
								@endif
				
					{!! Form::open(['url' => '/home/updateNote', 'method' => 'post']) !!}
					@foreach ($notes as $note)
                     {!! Form::hidden('id', $note->id) !!}

                            <fieldset>
                                <div class="form-group">
                                	<label style="color:white;" class="col-lg-3">Title</label>
									{!! Form::text('title', $note->title, ['class' => 'wpcf7-text required']) !!}
                                    
                                </div>
                            </fieldset>
            
                            <fieldset>
                                 <div class="form-group">
                                 	<label style="color:white;">Description</label>
                                    <div class="col-sx-12">
                                        {!! Form::textArea('description', $note->description, ['class' => 'wpcf7-textarea required', 'rows' => '5']) !!}
                                    </div>
                                     
                            </fieldset>
            
                            <fieldset>
                                <div class="form-group">
                                	<label style="color:white;" class="col-lg-3">Created Date</label>
                            		{!! Form::text('created_date', $note->created_date,['class'=>'form-control date-picker', 'readonly']) !!}
                                </div>
                            </fieldset>
                            
                            <fieldset>
                                 <div class="form-group">
                                 	<label style="color:white;" class="col-lg-3">Last Updated</label>
									{!! Form::text('last_updated', $note->last_updated, ['class' => 'wpcf7-text required', 'readonly']) !!}
                                </div>
                             </fieldset>
            

                        
                        <div style="clear:both;"></div>
                        <fieldset>
                            <div class="form-group">
                                {!! Form::submit('Update', ['class' => 'wpcf7-submit']) !!}
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form-group">
                                <a href="{{ url('/noteDetail/delete') }}/{{$note->id}}"><button type="button" class="btn btn-danger">Delete</button></a>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form-group">
                                <br/>
                                <div class="container">
                                  <div class="row">
                                       <div class="col-lg-12">
                                     <div class="button-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                  <li><a href="#" class="small" data-value="option1" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 1</a></li>
                                  <li><a href="#" class="small" data-value="option2" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 2</a></li>
                                  <li><a href="#" class="small" data-value="option3" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 3</a></li>
                                  <li><a href="#" class="small" data-value="option4" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 4</a></li>
                                  <li><a href="#" class="small" data-value="option5" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 5</a></li>
                                  <li><a href="#" class="small" data-value="option6" tabIndex="-1"><input type="checkbox"/>&nbsp;Option 6</a></li>
                                </ul>
                                  </div>
                                </div>
                                  </div>
                                </div>
                            </div>
                        </fieldset>
                        @endforeach
                	{!! Form::close() !!}
				
					
                    
                
				
            </div>
        </div>
    </div>
</div>
@endsection
