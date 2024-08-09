<div class="popUp-wrapper settings-popup">

    <div class="enter-new-email card">
        <form id="change-email-form">
            <div class="input-group">
                <label for="password">
                    Enter new email address
                </label>
                <input 
                    type="email" 
                    id="your-email" 
                    name="new_email" 
                    placeholder="Email" 
                    required />
                <div class="error-text"></div>
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
                <div class="error-text"></div>
                <div type="button" class="show-password">
                    <img src="{{ asset('/assets/img/mdi_eye-outline.svg') }}" alt="" />
                </div>
            </div>
            <button type="submit" class="submit btn red">
                Confirm
            </button>
        </form>

        <div class="text-error"></div>
    </div>

    <div class="add-new-pass card">
        <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close">
        <form id="change-password-form">
            <div class="input-group">
                <label for="password">
                    Enter current password
                </label>
                <input 
                    type="password" 
                    id="old-password" 
                    name="old_password" 
                    placeholder="Password" 
                    required />
                <div class="error-text"></div>
                <div type="button" class="show-password">
                    <img src="{{ asset('/assets/img/mdi_eye-outline.svg') }}" alt="" />
                </div>
            </div>
            <div class="input-group">
                <label for="password">
                    Enter new password
                </label>
                <input 
                    type="password" 
                    id="new-password" 
                    name="new_password" 
                    placeholder="Password" 
                    required />
                <div class="error-text"></div>
                <div type="button" class="show-password">
                    <img src="{{ asset('/assets/img/mdi_eye-outline.svg') }}" alt="" />
                </div>
                <p class="passRule">
                    Use 8-32 characters for your password
                </p>
            </div>

            <button type="submit" class="submit btn red">
                Confirm
            </button>

            <div class="text-error"></div>
        </form>
    </div>

    <div class="pass-succes card" id="pass-succes-changed">
        <p class="title">
            Your password has been successfully changed
        </p>
        <a class="btn red">
            Close
        </a>
    </div>

    <div class="pass-succes card" id="email-succes-changed">
        <p class="title">
            Your email has been successfully changed
        </p>
        <a class="btn red">
            Close
        </a>
    </div>
    
</div>
