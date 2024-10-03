@php
$isResetPage = request()->query('token') and request()->query('email');
@endphp 

<div class="popUp-wrapper  {{ $isResetPage ? 'active' : '' }}   authPopup">

    <div class="signUP-card card">
        <div class="close">
            <img src="{{ asset('assets/img/close.svg') }}" alt="" />
        </div>
        
        <p class="title">
            Sign up
        </p>

        <form id="sign-up">
            <div class="input-group">
                <label for="email">
                    Enter email
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="Email" 
                    required />
                <div class="error-text">
                    The Email is required
                </div>
            </div>
            
            <div class="input-group">
                <label for="password">
                    Enter password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Password" 
                    required />
                <div class="error-text">
                    The password is required
                </div>
                <div type="button" class="show-password">
                    <img src="{{ asset('assets/img/mdi_eye-outline.svg') }}" alt="" />
                </div>
                <p class="passRule">
                    Use 8-32 characters for your password
                </p>
            </div>
            <div class="input-group">
                <label for="password">
                    Confirm password
                </label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    placeholder="Password" 
                    required />
                <div class="error-text">
                    Passwords do not match
                </div>
                <div type="button" class="show-password">
                    <img src="{{ asset('assets/img/mdi_eye-outline.svg') }}" alt="" />
                </div>
                <p class="passRule">
                    Use 8-32 characters for your password
                </p>
            </div>
            <input 
                type="hidden" 
                name="from" 
                value="{{ request()->route()?->getName() == 'profile.page' ? (isset($creator) ? $creator->id : '') : '' }}">

            <button type="submit" class="submit btn red" disabled>
                Sign up
            </button>
        </form>

        <div class="text-error"></div>

        <p class="switch-to-login">
            Have an account? <span class="login-link">Log in</span>
        </p>
    </div>

    <div class="logIN-card card">
        <div class="close">
            <img src="{{ asset('assets/img/close.svg') }}" alt="" />
        </div>

        <p class="title">
            Log in
        </p>
        
        <form id="sign-in">
            <div class="input-group">
                <label for="email">
                    Enter email
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="Email" 
                    required />
                <div class="error-text">
                    The Email is required
                </div>
            </div>
            
            <div class="input-group">
                <label for="password">
                    Enter password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Password" 
                    required />
                <div class="error-text">
                    The password is required
                </div>
                <div type="button" class="show-password">
                    <img src="{{ asset('assets/img/mdi_eye-outline.svg') }}" alt="" />
                </div>
                <p class="reset-pass">Forgot password?</p>
            </div>

            <button type="submit" class="submit btn red" disabled>
                Log in
            </button>
            
        </form>

        <div class="text-error"></div>

        <p class="switch-to-signup">
            Don’t have an account? <span class="signup-link">Sign up</span>
        </p>
    </div>

    <div class="resetPassword-card card">
        <div class="close"> <img src="{{ asset('/assets/img/close.svg') }}" alt="" ></div>
        <p class="title">
            Enter email <br> for reset the password
        </p>

        <form id="forgot-password">
            <div class="input-group">
                <input 
                    type="email" 
                    id="reset-email" 
                    name="email" 
                    placeholder="Email" 
                    required />
                <div class="error-text">
                    The Email is required
                </div>
            </div>
            
            <button type="submit" class="submit btn red">
                Confirm
            </button>
        </form>

        <div class="text-error"></div>
    </div>

    <div class="res-succes-send card" id="res-succes-send">
        <p class="title">
          Your password reset message has been successfully sent to your email:
        </p>
        <p class="mail">email@gmail.com</p>
        <div class="btn red">
            Close
        </div>
    </div>

    <div class="addNew-pass-card card {{ $isResetPage ? 'active' : '' }}">
        <div class="close">
            <img src="{{ asset('assets/img/close.svg') }}" alt="" />
        </div>
        <p class="title">
            Add new password
        </p>
        <form id="new-password-form">
            <input type="hidden" name="token" value="{{ request()->query('token') }}">
            <input type="hidden" name="email" value="{{ request()->query('email') }}">
            <div class="input-group">
                <label for="new-password">
                    Enter new password
                </label>
                <input
                    type="password"
                    id="new-password"
                    name="password"
                    placeholder="Password"
                    required/>
                <div class="error-text">
                    The password is required
                </div>
            <div type="button" class="show-password">
                <img src="{{ asset('assets/img/mdi_eye-outline.svg') }}" alt="" />
            </div>
                <p class="passRule">
                    Use 8-32 characters for your new password
                </p>
            </div>
            <button type="submit" class="submit btn red">
                Confirm
            </button>
        </form>

        <div class="text-error"></div>
    </div>

    <div class="pass-succes card" id="res-succes-send">
        <p class="title">
            Your password has been successfully changed
        </p>
        <div class="btn red login">
            Log in
        </div>
    </div>

</div>