<div id="sidr" class="sidenav" style="display: none;">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <p>&nbsp;</p>
  @if(\Auth::check())
      <form action="{{ url('search') }}" id="head-form" class="navbar-form navbar-left search-form">
          <div class="form-group sm-dropdown">
            <input type="text" name="location" id="sidenav-search-form" class="form-control" placeholder="{{ trans('messages.header.where_are_you_going') }}" style="width:200px;margin-bottom:1px;">
            <div id="sidenav-search-drop-down" class="sm-dropdown-content">
                <div class="col-md-12" style="padding:0px 5px;">
                    <div class="col-md-4" style="padding:0px 5px;">
                        <label class="nav-label">{{ trans('messages.header.check_in') }}</label>
                        <input type="text" name="checkin" id="sidenav-search-checkin" class="nav-form-control" autocomplete="off" readonly="readonly">
                    </div>
                    <div class="col-md-4" style="padding:0px 5px;">
                        <label class="nav-label">{{ trans('messages.header.check_out') }}</label>
                        <input type="text" name="checkout" id="sidenav-search-checkout" class="nav-form-control" autocomplete="off" readonly="readonly">
                    </div>
                    <div class="col-md-4" style="padding:0px 5px;">
                        <label class="nav-label">{{ trans_choice('messages.header.guest', 2) }}</label>
                        <select class="nav-form-control" id="sidenav-search-guests" name="guests">
                            @for($i=1;$i<=16;$i++)
                              <option value="{{ $i }}"> {{ ($i == '16') ? $i.'+ ' : $i }} </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-12">
                      <button class="btn ex-btn navbar-btn topbar-btn" style="width:100%;" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        {{ trans('messages.header.find_place') }}
                      </button>
                    </div>
                </div>
            </div>
          </div>
      </form>
      <a href="{{ url('dashboard') }}">{{ trans('messages.header.dashboard') }}</a>
      <a href="{{ url('properties') }}">{{ trans_choice('messages.header.your_listing',2) }}</a>
      <a href="{{ url('my_bookings') }}">{{ trans('messages.sidenav.property_booking') }}</a>
      <a href="{{ url('trips/active') }}">{{ trans('messages.sidenav.your_trip') }}</a>
      <a href="{{ url('users/profile') }}">{{ trans('messages.header.edit_profile') }}</a>
      <a href="{{ url('users/account_preferences') }}">{{ trans('messages.header.account') }}</a>
      <a href="{{ url('logout') }}">{{ trans('messages.header.logout') }}</a>
      <a href="{{ url('property/create') }}">{{ trans('messages.header.list_space')}}</a>
  @else
    <a href="{{ url('signup') }}">{{ trans('messages.sign_up.sign_up') }}</a>
    <a href="{{ url('login') }}">{{ trans('messages.header.login') }}</a>
    <a href="{{ url('property/create') }}">{{ trans('messages.header.list_space') }}</a>
  @endif
</div>
<div role="contentinfo" class="page__footer">
    <footer class="footer">
        <div class="page__container footer__container">
            <b data-v-c7f6745c="" class="footer__title">С нами удобнее!</b>
            <div data-v-c7f6745c="" class="footer__row row">
                <div data-v-c7f6745c="" class="col col-12 col-lg-4">
                    <div data-v-c7f6745c="" class="footer__info">
                        <p data-v-c7f6745c="">Подпишитесь на рассылку и получайте новости от <strong></strong> первыми</p>
                    </div>
                    <form action="/subscribe" class="footer__subscription">
                        <label data-v-c7f6745c="" class="mdinput">
                            <span class="mdinput__label">Ваш e-mail</span>
                            <input type="text" class="mdinput__control">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon--chevron icon--right"><!----><use xlink:href="/img/icons.298999e9.svg#chevron-left" xmlns:xlink="http://www.w3.org/1999/xlink"></use></svg>
                        </label>
                    </form>
                </div>
                <div class="col col-12 col-lg-4">
                    <div class="footer__info">
                        <b class="footer__label">Горячая линия</b>
                        <a href="tel:undefined">979797979879</a>
                    </div>
                    <div class="footer__info">
                        <b class="footer__label">Почта</b>
                        <a href="mailto:undefined">jhvghv@hghg.gh</a>
                    </div>
                </div>
                <div class="col col-12 col-lg-4">
                    <div class="footer__info">
                        <b data-v-c7f6745c="" class="footer__label">Офис компании</b> jkjknkjnjknjk,<br> njbjbjbjhb,<br> knknknjnk,<br > knjnkknjk
                    </div>
                </div>
            </div>
            <div class="footer__row row">
                <div class="col col-12 col-lg-4">
                    <div class="footer__oses">
                        <div class="footer__os">
                            <a target="_blank">
                                <picture><source  srcset="/img/button_play_market@2x.142b9acc.png"><img data-v-c7f6745c="" src="asdsd" alt="Play market"></picture>
                            </a>
                        </div>
                        <div class="footer__os">
                            <a target="_blank">
                                <picture><source srcset="/img/button_app_store@2x.571dc116.png">
                                    <img src="" alt="App store">
                                </picture>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-lg-4">
                    <nav class="footer__nav"><ul>
                            <li >
                                <a href="/ru/" class="router-link-exact-active router-link-active"></a>
                            </li>
                            <li data-v-c7f6745c="">
                                <a data-v-c7f6745c="" href="/ru/" class="router-link-exact-active router-link-active"></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div data-v-c7f6745c="" class="col col-12 col-lg-4">
                    <nav data-v-c7f6745c="" class="networks">
                        <ul data-v-c7f6745c="">
                            <li data-v-c7f6745c="">
                                <a data-v-c7f6745c="" href="https://twitter.com" title="Twitter" target="_blank" class="network network--twitter"><svg data-v-c7f6745c="" xmlns="http://www.w3.org/2000/svg" class="icon icon--twitter"><!----><use xlink:href="/img/icons.298999e9.svg#twitter" xmlns:xlink="http://www.w3.org/1999/xlink"></use></svg></a></li>
                            <li data-v-c7f6745c=""><a data-v-c7f6745c="" href="https://www.youtube.com" title="YouTube" target="_blank" class="network network--youtube"><svg data-v-c7f6745c="" xmlns="http://www.w3.org/2000/svg" class="icon icon--youtube"><!----><use xlink:href="/img/icons.298999e9.svg#youtube" xmlns:xlink="http://www.w3.org/1999/xlink"></use></svg></a></li>
                            <li data-v-c7f6745c=""><a data-v-c7f6745c="" href="https://www.facebook.com" title="Facebook" target="_blank" class="network network--facebook"><svg data-v-c7f6745c="" xmlns="http://www.w3.org/2000/svg" class="icon icon--facebook"><!----><use xlink:href="/img/icons.298999e9.svg#facebook" xmlns:xlink="http://www.w3.org/1999/xlink"></use></svg></a>
                            </li><li data-v-c7f6745c=""><a data-v-c7f6745c="" href="https://www.instagram.com" title="Instagram" target="_blank" class="network network--instagram"><svg data-v-c7f6745c="" xmlns="http://www.w3.org/2000/svg" class="icon icon--instagram"><!----><use xlink:href="/img/icons.298999e9.svg#instagram" xmlns:xlink="http://www.w3.org/1999/xlink"></use></svg></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div data-v-c7f6745c="" class="footer__caption">
                <div data-v-c7f6745c="" class="row"><div data-v-c7f6745c="" class="col col-12 col-lg-auto">© 2020, ™</div>
                    <div data-v-c7f6745c="" class="col col-12 col-lg-auto">Art Direction <strong data-v-c7f6745c="">Anvar Rizaev</strong></div>
                    <div data-v-c7f6745c="" class="col col-12 col-lg-auto">
                        <a data-v-c7f6745c="" href="/ru/" class="router-link-exact-active router-link-active">Соглашение о конфиденциальности</a>
                    </div>
                </div>
            </div>
            <div data-v-c7f6745c="" class="footer__illustration">
                <img data-v-c7f6745c="" src="/img/illustration_footer.8cda0a44.svg" alt="footer">
            </div>
        </div>
    </footer>
</div>
{{--
<footer class="mg-footer">
  <div class="mg-footer-widget">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-6">
          <div class="widget">
          <h2 class="mg-widget-title">{{ trans('messages.static_pages.hosting') }}</h2>
            <ul class="list-layout">
              @if(isset($footer_first))
                @foreach(@$footer_first as $ff)
                  <li><a href="{{ url($ff->url) }}" class="link-contrast">{{ $ff->name }}</a></li>
                @endforeach
              @endif
            </ul>
          </div>
        </div>
        <div class="col-md-4 col-sm-6">
          <div class="widget">
            <h2 class="mg-widget-title">{{ trans('messages.static_pages.company') }}</h2>
            <ul class="list-layout">
              @if(isset($footer_second))
                @foreach(@$footer_second as $fs)
                  <li><a href="{{ url($fs->url) }}" class="link-contrast">{{ $fs->name }}</a></li>
                @endforeach
              @endif
            </ul>
          </div>
        </div>
        <div class="col-md-4 col-sm-6">
          <div class="widget">
            <form>
              <div class="col-md-12 col-sm-12 mb20">
              @if(isset($language))
                <select class="form-control footer-select" aria-labelledby="language-selector-label" id="language_footer" name="language">
                  @foreach($language as $key => $value)
                    <option value="{{$key}}" {{ (Session::get('language') == $key) ? 'selected' : '' }} > {{$value}}</option>
                  @endforeach
                </select>
              @endif
              </div>
              <div class="col-md-12 col-sm-12 mb20">
                @if(isset($language))
                  <select class="form-control footer-select" aria-labelledby="language-selector-label" id="currency_footer" name="language">
                    @foreach($currency as $key => $value)
                      <option value="{{$key}}" {{ (Session::get('currency') == $key) ? 'selected' : '' }} > {{$value}}</option>
                    @endforeach
                  </select>
                @endif
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mg-copyright">
    <div class="container">
      <div class="row">
        
        <div class="col-md-6">
          <ul class="mg-footer-nav">
            <li>© {{ @$site_name }}, Inc.</li>
          </ul>
        </div>
        <div class="col-md-6">
          <ul class="list-layout list-inline pull-right">
              <link href="" itemprop="url">
              <meta content="" itemprop="logo">
              @if(isset($join_us))
                @for($i=0; $i<count($join_us); $i++)
                  <li>
                    <a href="{{ $join_us[$i]->value }}" class="link-contrast footer-icon-container" target="_blank">
                      <i class="fa pad-top-4 fa-{{ str_replace('_','-',$join_us[$i]->name) }}"></i> 
                    </a>        
                  </li>
                @endfor
              @endif    
          </ul>
        </div>
      </div>
      
    </div>
  </div>
</footer>
--}}

<div id="alert_model" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button id="ok_id" type="button" class="btn btn-danger">Ok</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
