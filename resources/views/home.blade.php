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
					{!! Form::open(['url' => '/home/requestNote', 'method' => 'post']) !!}
					<form method="post">
						<div class="form-group">
							<label style="" class="">Title</label>
                            <div class="">
							{!! Form::text('title', null, ['class' => 'wpcf7-text required']) !!}
                            </div>
						</div>
						<div class="form-group">
							<label style="">Description</label>
							<div class="">
								{!! Form::textArea('description', null, ['class' => 'form-control required']) !!}<!-- , 'rows' => '5', 'cols' => '6' -->
							</div>
						</div>
                        <div class="form-group">
							<label style="" class="">Created Date:</label>
                            {!! Form::text('created_date', old('date_created', Carbon\Carbon::today()->format('Y-m-d')),['class'=>'wpcf7-text date-picker', 'readonly']) !!}
						</div>
                        <div class="form-group">
							{!! Form::hidden('last_updated', null, ['class' => 'wpcf7-text required', 'readonly']) !!}
						</div>
						<button type="submit" class="btn btn-primary" name="submit">Submit Note</button>
					</form>
					{!! Form::close() !!}
			</div>
			<div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                        	<h2>My Notes</h2>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Note</th>
                                        <th>Submitted By</th>
                                        <th>Title</th>
                                        <th>Last Updated</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
										<?php 
                                        foreach ($searchnotes as $searchnote){?>
                                        <tr class="active"> 
                                            <?php /*?><td><a href="/admin/userDetail/<?php echo $searchnote->userid; ?>"><?php echo $searchnote->userid; ?></a></td><?php */?>
                                            <td><?php echo $searchnote->id; ?></td>
                                            <td><?php echo $searchnote->name; ?></td>
                                            <td><?php echo $searchnote->title; ?></td>
                                            <td><?php echo $searchnote->last_updated; ?></td>
                                            <td><a href="{{ url('/noteDetail') }}/<?php echo $searchnote->id; ?>">OPEN</a></td>
                                        </tr>
                                        <?php 
                                        }; 
                                        ?>
                                </tbody>
                            </table>
                            <h2>My Deleted Notes</h2>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Note</th>
                                        <th>Submitted By</th>
                                        <th>Title</th>
                                        <th>Last Updated</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
										<?php 
                                        foreach ($deletednotes as $deletednote){?>
                                        <tr class="danger"> 
                                            <?php /*?><td><a href="/admin/userDetail/<?php echo $searchnote->userid; ?>"><?php echo $searchnote->userid; ?></a></td><?php */?>
                                            <td><?php echo $deletednote->id; ?></td>
                                            <td><?php echo $deletednote->name; ?></td>
                                            <td><?php echo $deletednote->title; ?></td>
                                            <td><?php echo $deletednote->last_updated; ?></td>
                                            <td><a href="{{ url('/noteDetail/activate') }}/<?php echo $deletednote->id; ?>">RETRIEVE</a></td>
                                        </tr>
                                        <?php 
                                        }; 
                                        ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                        	<h2>Recieved Notes</h2>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Note</th>
                                        <th>Submitted By</th>
                                        <th>Title</th>
                                        <th>Last Updated</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
										<?php 
                                        foreach ($recievednotes as $recievednote){?>
                                        <tr class="success"> 
                                            <?php /*?><td><a href="/admin/userDetail/<?php echo $searchnote->userid; ?>"><?php echo $searchnote->userid; ?></a></td><?php */?>
                                            <td><?php echo $recievednote->id; ?></td>
                                            <td><?php echo $recievednote->name; ?></td>
                                            <td><?php echo $recievednote->title; ?></td>
                                            <td><?php echo $recievednote->last_updated; ?></td>
                                            <td><a href="{{ url('/noteDetail') }}/<?php echo $recievednote->id; ?>">OPEN</a></td>
                                        </tr>
                                        <?php 
                                        }; 
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
