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

    .scrolling-container {
        height: 200px;
        overflow-y: scroll;
    }

    .notification-box {
        position: relative;
    }

    .notification-count {
        position: absolute;
        top: -8px;
        /* Adjust the top position as needed */
        right: -8px;
        /* Adjust the right position as needed */
        color: white;
        background-color: #1d0950;
        /* Background color */
        border-radius: 50%;
        padding: 3px 6px;
        /* Smaller padding */
        font-size: 10px;
        /* Smaller font size */
        transform: translate(50%, -50%);
        /* Center the count within the bell icon */
        animation: pulse 1s infinite;
        /* Simple pulse animation */
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }
</style>

<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
            <div class="logo-header-main"><a href="index.html"><img class="img-fluid for-light img-100"
                        src="../assets/images/logo/logo2.png" alt=""><img class="img-fluid for-dark"
                        src="../assets/images/logo/logo.png" alt="abc"></a></div>
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
                <li>
                    <div class="search">
                        <a href="{{ route('search-master') }}"><i class="fa fa-search"></i></a>
                    </div>
                </li>
                <li class="onhover-dropdown">
                    <div class="notification-box">
                        <i data-feather="bell"></i>
                        <span id="notification-count"
                            class="notification-count">{{ count(auth()->user()->unreadNotifications) }}</span>
                    </div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li><i data-feather="bell"> </i>
                            <h6 class="f-18 mb-0">Notitications</h6>
                        </li>
                        <li>
                            <div class="align-items-center scrolling-container">
                                @foreach (auth()->user()->notifications as $notification)
                                    <div class="flex-shrink-0"><i data-feather="shopping-cart"></i></div>
                                    <div class="flex-grow-1">
                                        @if (Auth::check() && Auth::user()->role_id == 6)
                                            @if ($notification->type == 'App\Notifications\TransferAcceptNotification')
                                                <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread-manager-transferaccept', $notification->id) }}">
                                                        New Notification of Transfer Accept by the Employee !</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            @else
                                                <p><b>{{ Auth::user()->first_name }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread-controller', $notification->id) }}">New
                                                        Product Isuue to the User!</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            @endif
                                        @elseif (Auth::check() && Auth::user()->role_id == 3)
                                            @if ($notification->type == 'App\Notifications\TransferNotification')
                                                <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread-transfer-manager', $notification->id) }}">Manager
                                                        New Notification of Transfer!</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            @elseif ($notification->type == 'App\Notifications\ReturnNotification')
                                                <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread-manager-return', $notification->id) }}">Manager
                                                        New Notification for Return!</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            @elseif ($notification->type == 'App\Notifications\TransferAcceptNotification')
                                                <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread-manager-transferaccept', $notification->id) }}">
                                                        New Notification of Transfer Accept by the Employee !</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            @else
                                                <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread-manager', $notification->id) }}">Manager
                                                        New Notification!</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            @endif
                                        @elseif(Auth::check() && Auth::user()->role_id == 1)
                                            @if ($notification->type == 'App\Notifications\IssuenceNotification')
                                                <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread-admin', $notification->id) }}">New
                                                        Asset Accepted by Employee!</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            @endif
                                        @else
                                            @if ($notification->type == 'App\Notifications\TransferNotification')
                                                <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread-transfer', $notification->id) }}">Employee
                                                        New Transfer
                                                        Notification!</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                            @else
                                                {{-- @if($notification->issuance_id) --}}
                                                <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                        href="{{ route('markasread', ['id' => $notification->id, 'typeId' => $notification->issuance_id]) }}">Employee
                                                        New
                                                        Notification!</a><span
                                                        class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                                {{-- @else
                                                <p><b>{{ $notification->data['name'] ?? '' }}</b>&nbsp;&nbsp;<a
                                                    href="{{ route('markasread', $notification->id) }}">Employee
                                                    New
                                                    Notification!</a><span
                                                    class="pull-right">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                                </p>
                                                @endif --}}
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </li>
                        {{-- @foreach (auth()->user()->notifications as $notification) --}}
                        <li><a class="btn btn-primary" href="{{ route('check-all-notification') }}">Check
                                all notification</a></li>
                        {{-- @endforeach --}}
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
                        <li><a href="{{ route('settings.user') }}"><i
                                    data-feather="settings"></i><span>Settings</span></a></li>
                        <li><a href="{{ route('logout') }}"><i data-feather="log-in"> </i><span>Log Out</span></a>

                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <script src="https://translate.google.com/translate_a/element.js?cb=loadGoogleTranslate"></script>
        <script>
            function receiveNewNotification() {
                const notificationCountElement = document.getElementById("notification-count");
                const currentCount = parseInt(notificationCountElement.innerText, 10);
                notificationCountElement.innerText = (currentCount + 1).toString();
            }

            function resetNotificationCount() {
                const notificationCountElement = document.getElementById("notification-count");
                notificationCountElement.innerText = "0";
            }
        </script>
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
