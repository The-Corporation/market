@extends('admin.admin_template')
@section('content')
   <!-- Main content -->
<section class="content">
<div class="row">
<div class="col-md-3">
<a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a>
<div class="box box-solid">
<div class="box-header with-border">
  <h3 class="box-title">Folders</h3>
  <div class="box-tools">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>
<div class="box-body no-padding">
  <ul class="nav nav-pills nav-stacked">
    <li class="active"><a href="#"><i class="fa fa-inbox"></i> Inbox <span class="label label-primary pull-right">{{ $messages->count() }}</span></a></li>
    <li><a href="#"><i class="fa fa-envelope-o"></i> Sent</a></li>
    <li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>
  </ul>
</div><!-- /.box-body -->
</div><!-- /. box -->
<div class="box box-solid">
<div class="box-header with-border">
  <h3 class="box-title">Labels</h3>
  <div class="box-tools">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>
<div class="box-body no-padding">
  <ul class="nav nav-pills nav-stacked">
    <li><a href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li>
    <li><a href="#"><i class="fa fa-circle-o text-light-blue"></i> Social</a></li>
  </ul>
</div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col -->
<div class="col-md-9">
<div class="box box-primary">
<div class="box-header with-border">
  <h3 class="box-title">Inbox</h3>
  <div class="box-tools pull-right">
    <div class="has-feedback">
      <input type="text" class="form-control input-sm" placeholder="Search Mail">
      <span class="glyphicon glyphicon-search form-control-feedback"></span>
    </div>
  </div><!-- /.box-tools -->
</div><!-- /.box-header -->
<div class="box-body no-padding">
  <div class="mailbox-controls">
    <!-- Check all button -->
    <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
    <div class="btn-group">
      <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
      <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
      <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
    </div><!-- /.btn-group -->
    <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
    <div class="pull-right">
      1-50/200
      <div class="btn-group">
        <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
        <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
      </div><!-- /.btn-group -->
    </div><!-- /.pull-right -->
  </div>
  <div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
      <tbody>
      @foreach ($messages as $message)
        <tr>
          <td><input type="checkbox"></td>
          <td class="mailbox-star"><a href="#"><i class="fa fa-star text-aqua"></i></a></td>
          <td class="mailbox-name">
          <a href="{{ route('admin.readmessage',['id'=>$message->id]) }}">
          {{ $message->user->personinfo ? $message->user->personinfo->firstname : " "}} 
          {{ $message->user->personinfo ? $message->user->personinfo->lastname : " "}}
          </a>
          </td>
          <td class="mailbox-subject"><a href="{{ route('admin.readmessage',['id'=>$message->id]) }}"><b>{{ $message->subject}}</b>..</a></td>
          <td class="mailbox-attachment"></td>
          <td class="mailbox-date">{{ $message->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
      </tbody>
    </table><!-- /.table -->
  </div><!-- /.mail-box-messages -->
</div><!-- /.box-body -->
<div class="box-footer no-padding">
  <div class="mailbox-controls">
    <!-- Check all button -->
    <button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
    <div class="btn-group">
      <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
      <button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
      <button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
    </div><!-- /.btn-group -->
    <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
    <div class="pull-right">
      1-50/200
      <div class="btn-group">
        <button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
        <button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
      </div><!-- /.btn-group -->
    </div><!-- /.pull-right -->
  </div>
</div>
</div><!-- /. box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
@endsection