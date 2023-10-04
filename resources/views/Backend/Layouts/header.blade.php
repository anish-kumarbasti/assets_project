<style>
    .VIpgJd-ZVi9od-ORHb-OEVmcd {
        left: 0;
        top: 0;
        height: 39px;
        width: 100%;
        z-index: 10000001;
        position: fixed;
        border: none;
        border-bottom: 1px solid #6B90DA;
        margin: 0;
        box-shadow: 0 0 8px 1px #999;
        display: none !important;
    }

    .goog-te-banner-frame.skiptranslate,
    .goog-te-gadget-icon {
        display: none !important;
    }

    body {
        top: 0px !important;
    }

    .goog-tooltip {
        display: none !important;
    }

    .goog-tooltip:hover {
        display: none !important;
    }

    .goog-text-highlight {
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }
</style>

<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
            <div class="logo-header-main"><a href="index.html"><img class="img-fluid for-light img-100" src="../assets/images/logo/logo2.png" alt=""><img class="img-fluid for-dark" src="../assets/images/logo/logo.png" alt=""></a></div>
        </div>
        <div class="left-header col horizontal-wrapper ps-0">
        </div>
        <div class="nav-right col-6 pull-right right-header p-0">
            <ul class="nav-menus">
                {{-- <div class="input-group p-2">
             <input type="text" class="form-control" placeholder="Search">
             <div class="input-group-append">

              <i class="fa fa-search"></i>

          </div>
          </div> --}}
                <div id="google_element"></div>
                <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li>
                <li class="onhover-dropdown">
                    <div class="notification-box"><i data-feather="bell"></i></div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li><i data-feather="bell"> </i>
                            <h6 class="f-18 mb-0">Notitications</h6>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">

                                <!-- <div class="flex-grow-1">
                                    <p><a href="order-history.html">Asset alloted! </a><span class="pull-right">6
                                            hr</span></p>
                                </div> -->
                            </div>
                        </li>
                        <li>
                            <div class="align-items-center">
                                @foreach (auth()->user()->notifications as $notification)
                                <div class="flex-shrink-0"><i data-feather="shopping-cart"></i></div>
                                <div class="flex-grow-1">
                                    @if (Auth::check() && Auth::user()->role_id == 4)
                                    <p><b>{{ Auth::user()->first_name }}</b>&nbsp;&nbsp;<a href="{{ route('markasread-controller', $notification->id) }}">New
                                            Product Isuue to the User!</a><span class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                    </p>
                                    @elseif (Auth::check() && Auth::user()->role_id == 3)
                                    <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a href="{{ route('markasread-manager', $notification->id) }}">Manager
                                            New Notification!</a><span class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                    </p>
                                    @else
                                    <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a href="{{ route('markasread', $notification->id) }}">Employee New
                                            Notification!</a><span class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                    </p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </li>

                        <li><a class="btn btn-primary" href="javascript:void(0)">Check all notification</a></li>
                    </ul>
                </li>
                {{-- <li class="onhover-dropdown">
                <div class="message"><i data-feather="message-square"></i></div>
                <ul class="message-dropdown onhover-show-div">
                  <li><i data-feather="message-square">            </i>
                    <h6 class="f-18 mb-0">Messages</h6>
                  </li>
                  <li>
                    <div class="d-flex align-items-start">
                      <div class="message-img bg-light-primary"><img src="../assets/images/user/3.jpg" alt=""></div>
                      <div class="flex-grow-1">
                        <h5 class="mb-1"><a href="email_inbox.html">User 1</a></h5>
                        <p>Ha</p>
                      </div>
                      <div class="notification-right"><i data-feather="x"></i></div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex align-items-start">
                      <div class="message-img bg-light-primary"><img src="../assets/images/user/6.jpg" alt=""></div>
                      <div class="flex-grow-1">
                        <h5 class="mb-1"><a href="email_inbox.html">Jason Borne</a></h5>
                        <p>Thank you for rating us.</p>
                      </div>
                      <div class="notification-right"><i data-feather="x"></i></div>
                    </div>
                  </li>
                  <li>
                    <div class="d-flex align-items-start">
                      <div class="message-img bg-light-primary"><img src="../assets/images/user/10.jpg" alt=""></div>
                      <div class="flex-grow-1">
                        <h5 class="mb-1"><a href="email_inbox.html">Sarah Loren</a></h5>
                        <p>What`s the project report update?</p>
                      </div>
                      <div class="notification-right"><i data-feather="x"></i></div>
                    </div>
                  </li>
                  <li><a class="btn btn-primary" href="email_inbox.html">Check Messages</a></li>
                </ul>
              </li> --}}
                <li class="profile-nav onhover-dropdown">
                    <div class="account-user"><i data-feather="user"></i></div>
                    <ul class="profile-dropdown onhover-show-div">
                        <!-- <li><a href="user-profile.html"><i data-feather="user"></i><span>Account</span></a></li>
                        <li><a href="email_inbox.html"><i data-feather="mail"></i><span>Inbox</span></a></li> -->
                        <li><a href="{{ route('settings.user') }}"><i data-feather="settings"></i><span>Settings</span></a></li>
                        <li><a href="{{ route('logout') }}"><i data-feather="log-in"> </i><span>Log Out</span></a>

                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <script src="https://translate.google.com/translate_a/element.js?cb=loadGoogleTranslate"></script>
        <script>
            function loadGoogleTranslate() {
                var translator = new google.translate.TranslateElement({
                    pageLanguage: 'en',
                    includedLanguages: 'en,zh-CN,zh-TW,am,ar,eu,bn,en-GB,en,gu,hi,ru,ta,te,tr,ur,',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                    autoDisplay: false
                }, 'google_element');
            }
        </script>
        <script>
            function hideDynamicallyAddedElements() {
                var headerElement = document.querySelector('.header-wrapper');
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.addedNodes.length > 0) {

                            mutation.addedNodes.forEach(function(node) {
                                if (node.tagName === 'TABLE') {
                                    node.style.display = 'none';
                                }
                            });
                        }
                    });
                });
                var observerConfig = {
                    childList: true,
                    subtree: true
                };
                observer.observe(headerElement, observerConfig);
            }
            hideDynamicallyAddedElements();
        </script>
        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName"></div>
            </div>
            </div>
          </script>
        <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
    </div>
</div>