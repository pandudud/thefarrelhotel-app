@extends('layouts.master')

@section('title', $title)

@push('styles')
@endpush

@section('content')
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{url('home')}}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Pengaturan Hak Akses</span>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box portlet-theme">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-grid"></i>Data Hak Akses </div>
                <div class="tools">
                    <a href="" class="fullscreen"> </a>
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal" id="content">
                	<div class="form-actions">
                        <div class="row">
                            <div class="col-md-10">
                                
                            </div>
                            <div class="col-md-2 text-right">
                                <a class="btn blue-dark col-md-12" id="save">
                                    <i class="fa fa-check"></i>
                                    Simpan
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <ul class="nav nav-tabs tabs-left">
                                	@foreach ($level_id as $key => $item)
                                    <li class="{{ $key == 0 ? 'active' : '' }}">
                                        <a href="#tab_1" id="{{$item->id}}" class="nav" data-id="{{$item->id}}" data-toggle="tab"> {{$item->name}} </a>
                                    </li>
                                	@endforeach
                                </ul>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                    	<ul style="list-style: none;">
	                                        <li class="md-checkbox-list">
	                                            @each('pengaturan.hak-akses.data', $all_menus, 'all_menu')
	                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
    	$(document).ready(function(){

    		App.blockUI({
                target: '#content'
            });
			$.ajax({
				type: "GET",
                url: "{{ url('pengaturan/hak-akses').'/'.$first_level_id }}",
                success: function(data){
                	$('input:checkbox').removeAttr('checked');
                	for (var i = 0, len = data.length; i < len; i++) {
						var menu_id = data[i];
						$('input:checkbox[data-menu-id="'+menu_id+'"]').prop('checked', true);
					}
					App.unblockUI('#content');
                },
                error: function(){
                    swal("Error!", "Silahkan hubungi administrator", "error")
                    App.unblockUI('#content');
                }
            });

            $("input:checkbox").on("click", function(){
                var checked = $(this).prop('checked');
                var parent = $(this).parent().parent();
                if(parent.next('ul').length){
                    var ul = parent.next();
                    ul.find('input:checkbox').prop('checked', checked);
                }
            });

    		$(".nav li a.nav").on("click", function(){
    			App.blockUI({
	                target: '#content'
	            });
    			var on_click_id = $(this).data('id');
				$.ajax({
					type: "GET",
                    url: "{{ url('pengaturan/hak-akses') }}/"+on_click_id,
                    success: function(data){
                    	$('input:checkbox').removeAttr('checked');
                    	for (var i = 0, len = data.length; i < len; i++) {
							var menu_id = data[i];
							$('input:checkbox[data-menu-id="'+menu_id+'"]').prop('checked', true);
						}
						App.unblockUI('#content');
                    },
                    error: function(){
                        swal("Error!", "Silahkan hubungi administrator", "error")
                        App.unblockUI('#content');
                    }
                });
    		});

    		$("#save").on("click", function(){
    			var level_id = $('.nav li.active a').data('id');
    			var menu_id = [];
    			var i = 0;
    			$('.md-check:checkbox:checked').each(function () {
				    menu_id[i] = $(this).data('menuId');
				    i++;
				});
    			swal({
                    title: "Anda yakin?",
                    text: "Update permission",
                    type: "warning",
                    showCancelButton: true
                }).then(function(){
                    App.blockUI();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('pengaturan/hak-akses') }}",
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content"),
                        },
                        data: {
                        	'level_id': level_id,
                        	'menu_id': menu_id
                        },
                        success: function(data){
                           window.location.href = data;
                        },
                        error: function(){
                            swal("Error!", "Silahkan hubungi administrator", "error")
                            App.unblockUI();
                        }
                    });
                }).catch(swal.noop);
    		});

    	});
    </script>
@endpush