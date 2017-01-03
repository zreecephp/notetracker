@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
					</button> <a class="navbar-brand" href="{{ url('/home') }}">Note Manager</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="{{ url('/logout') }}">Sign Out</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<div class="jumbotron">
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
                    <form method="post">
					@foreach ($notes as $note)
                     {!! Form::hidden('id', $note->id) !!}
                            <fieldset>
                                <div class="form-group">
                                	<label style="" class="">Title</label>
                                    <div class="">
									{!! Form::text('title', $note->title, ['class' => 'wpcf7-text required']) !!}
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                 <div class="form-group">
                                 	<label style="">Description</label>
                                    <div class="">
                                        {!! Form::textArea('description', $note->description, ['class' => 'form-control required', 'rows' => '5']) !!}
                                    </div>
                                 </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                	<label style="" class="">Created Date</label>
                            		{!! Form::text('created_date', $note->created_date,['class'=>'wpcf7-text date-picker', 'readonly']) !!}
                                </div>
                            </fieldset>
                            <fieldset>
                                 <div class="form-group">
                                 	<label style="" class="">Last Updated</label>
									{!! Form::text('last_updated', $note->last_updated, ['class' => 'wpcf7-text required', 'readonly']) !!}
                                </div>
                             </fieldset>
                            <div style="clear:both;"></div>
                            <fieldset>
                                <div class="form-group">
									<button type="submit" class="btn btn-primary custombutton" name="submit">Update Note</button>
                                </div>
                            </fieldset>
                  </form>
                            <fieldset>
                                <div class="form-group">
                                    <a href="{{ url('/noteDetail/delete') }}/{{$note->id}}"><button type="button" class="btn btn-primary custombutton">Delete</button></a>
                                </div>
                            </fieldset>
                 @endforeach
                 {!! Form::close() !!}
                            <fieldset>
                                <div class="form-group">
                                    <div class="btn-group">
                                        <button id="opener" class="btn btn-primary custombutton">Share Note</button>
                                            <div id="dialog" title="Select User/Users" style="width:600px; height:600px;">
                                                <a href="{{ url('/noteDetail/shareAllUsers') }}/<?php echo $note->id; ?>"><button class="btn btn-default" style="width:100px;">All</button></a>
                                                {!! Form::open(['url' => '/home/shareSelectedUsers', 'method' => 'post']) !!}
                                                   <ul style="list-style-type: none;">
                                                       <li><h4>OR</h4></li>
                                                       {!! Form::hidden('id', $note->id) !!}
                                                          @foreach ($users as $user)
                                                            <li><input type="checkbox" name="sharenote[]" value="{{ $user->id }}"/>&nbsp;{{ $user->name }}</li>
                                                          @endforeach
                                                   </ul>
                                                <button type="submit" class="btn btn-primary" name="submit">Submit Share</button>
                                                {!! Form::close() !!}
                                           </div>
                                   </div>
                              </div>
                           </fieldset>
			</div>
		</div>
	</div>
</div>
@endsection
