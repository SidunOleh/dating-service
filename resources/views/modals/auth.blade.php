<div class="popUp-wrapper">

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
                <input type="email" id="email" name="email" placeholder="Email" required />
                <div class="error-text">
                    The Email is required
                </div>
            </div>
            
            <div class="input-group">
                <label for="password">
                    Enter password
                </label>
                <input type="password" id="password" name="password" placeholder="Password" required />
                <div class="error-text">
                    The password is required
                </div>
                <div type="button" class="show-password">
                    <img src="{{ asset('assets/img/mdi_eye-outline.svg') }}" alt="" />
                </div>
                <p class="passRule">
                    Use 8-32 characters for your password
                </p>
                <input type="hidden" name="from" value="{{ request()->route()->getName() == 'profile.page' ? $creator->id : '' }}">
            </div>

            <button type="submit" class="submit btn red" disabled>
                Sign up
            </button>
        </form>

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
                <input type="email" id="email" name="email" placeholder="Email" required />
                <div class="error-text">
                    The Email is required
                </div>
            </div>
            
            <div class="input-group">
                <label for="password">
                    Enter password
                </label>
                <input type="password" id="password" name="password" placeholder="Password" required />
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
            
            <p class="switch-to-signup">
                Don’t have an account? <span class="signup-link">Sign up</span>
            </p>

        </form>
    
    </div>

    <div class="resetPassword-card card">
        <p class="title">
            Enter email for reset the password
        </p>

        <form id="forgot-password">
            <div class="input-group">
                <input type="email" id="reset-email" name="email" placeholder="Email" required />
                <div class="error-text">
                    The Email is required
                </div>
            </div>
            <button type="submit" class="submit btn red">
                Confirm
            </button>
        </form>
    </div>

</div>