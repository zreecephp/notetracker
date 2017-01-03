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
				
					{!! Form::open(['url' => '/home/requestNote', 'method' => 'post']) !!}
					<form method="post">
						<div class="form-group">
							<label style="color:white;" class="col-lg-3">Title</label>
							{!! Form::text('title', null, ['class' => 'wpcf7-text required']) !!}
						</div>
						<div class="form-group">
							<label style="color:white;">Description</label>
							<div class="col-sx-12">
								{!! Form::textArea('description', null, ['class' => 'wpcf7-textarea required', 'rows' => '5']) !!}
							</div>
						</div>
                        <div class="form-group">
							<label style="color:white;" class="col-lg-3">Created Date</label>
                            {!! Form::text('created_date', old('date_created', Carbon\Carbon::today()->format('Y-m-d')),['class'=>'form-control date-picker', 'readonly']) !!}
                            
						</div>
                        <div class="form-group">
							<label style="color:white;" class="col-lg-3">Last Updated</label>
							{!! Form::text('last_updated', null, ['class' => 'wpcf7-text required', 'readonly']) !!}
						</div>
						<button type="submit" class="btn btn-primary" name="submit">Submit Note</button>
					</form>
					{!! Form::close() !!}
                    
                    
                    
                    <table>
                     	<tr>
                        	<td colspan="9" style="background-color:rgb(11,103,205); color:white; padding-left:5px;"><h4>My Notes&nbsp;</h4></td>
                        </tr>
                     	<tr style="background-color:rgb(45,137,239); color:white;">
                        	<td>Note</td>
                            <td>Submitted By</td>
                        	<td style=""><h5>Title</h4></td>
                            <td><h5>Description</h4></td>
                            <td style=""><h5>Created Date</h5></td>
                            <td style=""><h5>Last Updated</h5></td>
                            <td>Open</td>
                        </tr>

                        <?php 
						
                              foreach ($searchnotes as $searchnote){?>
                        <tr> 
                    		<?php /*?><td><a href="/admin/userDetail/<?php echo $searchnote->userid; ?>"><?php echo $searchnote->userid; ?></a></td><?php */?>
                            <td><?php echo $searchnote->id; ?></td>
                            <td><?php echo $searchnote->name; ?></td>
                            <td><?php echo $searchnote->title; ?></td>
                            <td><?php echo $searchnote->description; ?></td>
                            <td><?php echo $searchnote->created_date; ?></td>
                            <td><?php echo $searchnote->last_updated; ?></td>
                            <td><a href="{{ url('/noteDetail') }}/<?php echo $searchnote->id; ?>">OPEN</a></td>
                        </tr>
                        <?php }; 
						?>
                        
                     </table>
                     
                     
                     <table>
                     	<tr>
                        	<td colspan="9" style="background-color:rgb(11,103,205); color:white; padding-left:5px;"><h4>Discarded Notes&nbsp;</h4></td>
                        </tr>
                     	<tr style="background-color:rgb(45,137,239); color:white;">
                        	<td>Note</td>
                            <td>Submitted By</td>
                        	<td style=""><h5>Title</h4></td>
                            <td><h5>Description</h4></td>
                            <td style=""><h5>Created Date</h5></td>
                            <td style=""><h5>Last Updated</h5></td>
                            <td>Open</td>
                        </tr>

                        <?php 
						
                              foreach ($deletednotes as $deletednote){?>
                        <tr> 
                    		<?php /*?><td><a href="/admin/userDetail/<?php echo $searchnote->userid; ?>"><?php echo $searchnote->userid; ?></a></td><?php */?>
                            <td><?php echo $deletednote->id; ?></td>
                            <td><?php echo $deletednote->name; ?></td>
                            <td><?php echo $deletednote->title; ?></td>
                            <td><?php echo $deletednote->description; ?></td>
                            <td><?php echo $deletednote->created_date; ?></td>
                            <td><?php echo $deletednote->last_updated; ?></td>
                            <td><a href="{{ url('/noteDetail/activate') }}/<?php echo $deletednote->id; ?>">OPEN</a></td>
                        </tr>
                        <?php }; 
						?>
                        
                     </table>
                    
                
				
            </div>
        </div>
    </div>
</div>
@endsection
