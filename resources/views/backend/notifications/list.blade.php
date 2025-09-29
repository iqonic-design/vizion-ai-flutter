<div class="card-header border-bottom p-3">
  <h5 class="mb-0">{{ __('messages.all_notifications') }} ({{ $all_unread_count }})</h5>
</div>
<div class="card-body overflow-auto card-header-border p-0 card-body-list max-17 scroll-thin">
    <div class="dropdown-menu-1 overflow-y-auto list-style-1 mb-0 notification-height">
        @if(isset($notifications) && count($notifications) > 0)
       
            @foreach($notifications->sortByDesc('created_at')->take(5) as $notification)
               @if($notification->data['data']['notification_group']=='subscription')
                <div class="dropdown-item-1 float-none p-3 list-unstyled iq-sub-card  {{ $notification->read_at ? '':'notify-list-bg'}} ">
  
                  <div class="d-flex justify-content-between">
                    <h6>{{ $notification->data['subject']}}</h6>
                      <h6>#{{ $notification->data['data']['id']}}</h6>
                    </div>
                    <div class="list-item d-flex">
                    @php
                
                  @endphp
                      
                        <div class="list-style-detail">
                          @if($notification->data['data']['notification_type']=='new_subscription')
                            <p class="text-body mb-1">{{ ($notification->data['data']['username']) }} is subscribe as a {{ ($notification->data['data']['identifier']) }} User<span class="text-black"></span></p>
                            
                            @endif

                        </div>
                    </div>
                  </a>
                </div>
               
                @endif

                @if($notification->data['data']['notification_group']=='recharge_reminder')
                <div class="dropdown-item-1 float-none p-3 list-unstyled iq-sub-card  {{ $notification->read_at ? '':'notify-list-bg'}} ">
  
                  <div class="d-flex justify-content-between">
                    <h6>{{ $notification->data['subject']}}</h6>
                    </div>
                    <div class="list-item d-flex">
                      
                        <div class="list-style-detail">
                          @if($notification->data['data']['notification_type']=='recharge_reminder')
                            <p class="text-body mb-1">Your {{$notification->data['data']['service_name']}} account balance is insufficient.<span class="text-black"></span></p>
                            
                            @endif

                        </div>
                    </div>
                  </a>
                </div>
               
                @endif
            @endforeach
        @else
            <li class="list-unstyled dropdown-item-1 float-none p-3">
                <div class="list-item d-flex justify-content-center align-items-center">
                    <div class="list-style-detail ml-2 mr-2">
                    <h6 class="font-weight-bold">{{ __('messages.no_notification') }}</h6>
                    <p class="mb-0"></p>
                    </div>
                </div>
            </li>
        @endif
    </div>
</div>
<div class="card-footer py-2 border-top">
  <div class="d-flex align-items-center justify-content-between">
      @if($all_unread_count > 0 )
        <a href="#" data-type="markas_read" class="text-primary mb-0 notifyList pull-right" ><span>{{__('messages.mark_all_as_read') }}</span></a>
      @endif
      @if(isset($notifications) && count($notifications) > 0)
        <a href="{{ route('backend.notifications.index') }}" class="btn btn-sm btn-primary">{{ __('messages.view_all') }}</a>
      @endif
  </div>  
</div>
{{-- @if(isset($notifications) && count($notifications) > 0)
<div class="card-footer text-muted p-3 text-center ">
    <a href="{{ route('backend.notifications.index') }}" class="mb-0 btn-link btn-link-hover font-weight-bold view-all-btn">{{ __('messages.view_all') }}</a>
</div>
@endif --}}
