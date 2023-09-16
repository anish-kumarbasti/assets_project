@extends('Backend.Layouts.panel')

@section('Content-Area')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>Mail Setting</h3></div>
                {{-- <h4>Mail Setting</h4> --}}
                <div class="card-body">
                    <form method="POST" action="{{ route('emails.update') }}">
                        @csrf
                        @method('PUT');
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_transport">{{ __('Mail Transport') }}</label>
                                    <input id="mail_transport" type="text" class="form-control" name="mail_transport" value="{{ old('mail_transport', config('mail.mail_transport')) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_host">{{ __('Mail Host') }}</label>
                                    <input id="mail_host" type="text" class="form-control" name="mail_host" value="{{ old('mail_host', config('mail.mail_host')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_port">{{ __('Mail Port') }}</label>
                                    <input id="mail_port" type="text" class="form-control" name="mail_port" value="{{ old('mail_port', config('mail.mail_port')) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_username">{{ __('Mail Username') }}</label>
                                    <input id="mail_username" type="text" class="form-control" name="mail_username" value="{{ old('mail_username', config('mail.mail_username')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_password">{{ __('Mail Password') }}</label>
                                    <input id="mail_password" type="password" class="form-control" name="mail_password" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_encryption">{{ __('Mail Encryption') }}</label>
                                    <input id="mail_encryption" type="text" class="form-control" name="mail_encryption" value="{{ old('mail_encryption', config('mail.mail_encryption')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_from">{{ __('Mail From') }}</label>
                                    <input id="mail_from" type="text" class="form-control" name="mail_from" value="{{ old('mail_from', config('mail.from.address')) }}" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
