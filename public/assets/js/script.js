Fancybox.bind('[data-fancybox]', {})

//__________________________Header__________________________//

$('.burger-menu').click(function () {
    $('.header-menu').toggleClass('open')
})

$('.header-menu .close').click(function () {
    $('.header-menu').removeClass('open')
})

//__________________________Cards__________________________//

$('.user-image .arrow').on('click', function (e) {
    e.preventDefault()
    e.stopPropagation()
})

//__________________________Sliders__________________________//

$('.img-slider').each(function () {
    var $slider = $(this)
    var $parent = $slider.closest('.user-image')

    $slider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: $parent.find('.prev'),
        nextArrow: $parent.find('.next'),
    })
})

//_____________________Popups______________________//

const $popupWrapper = $('.popUp-wrapper')
const $header = $('.header')
const $cards = {
    signUp: $('.signUP-card'),
    logIn: $('.logIN-card'),
    resetPassword: $('.resetPassword-card'),
    resSuccesSend: $('.res-succes-send'),
    addNewPassCard: $('.addNew-pass-card'),
    passSucces: $('.pass-succes'),
    newEmail: $('.enter-new-email'),
    newPass: $('.add-new-pass'),
    passSuccesChanged: $('#pass-succes-changed'),
    emailSuccesChanged: $('#email-succes-changed'),
}

function togglePopup(cardName, show) {
    $popupWrapper.toggleClass('active', show)
    
    $('html').toggleClass('no-scroll', show)
    
    $header.toggleClass('hidden', show && $(window).width() < 768)

    Object.values($cards).forEach($c => $c.removeClass('active'))

    if (show) {
        $cards[cardName].addClass('active')
    }
}

$('.btn.login, .header-burger').on('click', () => togglePopup('logIn', true))
$('.btn.signup, .signup-link').on('click', () => togglePopup('signUp', true))
$('.reset-pass').on('click', () => togglePopup('resetPassword', true))
$('.close').on('click', () => togglePopup('', false))

$('.show-password').on('click', function () {
    const $passwordInput = $(this).closest('.input-group').find('input')
    const isPassword = $passwordInput.attr('type') === 'password'
    $passwordInput.attr('type', isPassword ? 'text' : 'password')
    $(this).toggleClass('open', isPassword)
})

function enableSubmitButton($form) {
    const $inputs = $form.find('input[type="email"], input[type="password"]')
    const $submitButton = $form.find('.submit.btn')

    const checkInputs = () => {
        const allFilled = $inputs
            .toArray()
            .every((input) => $(input).val().trim() !== '')
        $submitButton.prop('disabled', !allFilled)
    }

    $inputs.on('input', checkInputs)

    checkInputs()
}

$('.signUP-card form, .logIN-card form, .resetPassword-card form').each(function () {
    enableSubmitButton($(this))
})

//__________________________AJAX Setup_________________________//

$.ajaxSetup({beforeSend: xhr => xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content')),})

//__________________________Loader_________________________//

function addLoader(selector) {
    $(selector).append('<div class="loading"></div>')
}

function removeLoader(selector) {
    $(selector).find('.loading').remove()
}

//__________________________Advertising_________________________//

if (DS.ads?.data && DS.ads?.settings) {
    const adPopup = {
        counters: {
            secs: 0,
            clicks: 0,
        },
        next: null,
        showing: false,
        interval: null,
        get secsCount() {
            return this.counters.secs
        },
        set secsCount(count) {
            if (this.showing) {
                return
            }

            if (count >= parseInt(DS.ads.settings.seconds_between_popups)) {
                this.showing = true
                clearInterval(this.interval)
                this.show()
            } else {
                this.counters.secs = count
            }
        },
        get clicksCount() {
            return this.counters.clicks
        },
        set clicksCount(count) {
            if (this.showing) {
                return
            }

            if (count >= parseInt(DS.ads.settings.clicks_between_popups)) {
                this.showing = true
                clearInterval(this.interval)
                this.show()
            } else {
                this.counters.clicks = count
            }
        },
        show() {
            if (! this.next) {
                return
            }

            const popup = $('.advertising-wrapper')
            const img = $('.advertising-img')
            const link = $('.advertising-link')
    
            img.attr('src', this.next.image.url)
            link.data('id', this.next.id)
            link.attr('href', this.next.link)

            adCloseTimer.start(DS.ads.settings.close_popup_seconds)

            popup.addClass('show')

            this.getNext()
        },
        hide() {
            this.counters.secs = 0
            this.counters.clicks = 0

            this.interval = setInterval(() => {
                this.secsCount += 1
            }, 1000)

            this.showing = false

            $('.advertising-wrapper').removeClass('show')
        },
        getNext() {
            if (! DS.ads.data.length) {
                return
            }

            const min = 0
            const max = DS.ads.data.length - 1
            const rand = Math.floor(Math.random() * (max - min + 1)) + min
            this.next = DS.ads.data[rand]

            this.predownloadNextImage()
        },
        predownloadNextImage() {
            const image = new Image 
            image.src = this.next.image.url 
        },
        ini() {
            this.getNext()

            $('.advertising-wrapper').on('click', '.advertising-close-timer.enabled', () => {
                this.hide()
            })
        
            $('.users-item.profile-item').bind('click auxclick', () => {
                this.clicksCount += 1
            })

            $('.advertising-link').bind('auxclick click', function () {
                $.post(`/ads/${$(this).data('id')}/click`)
            })
        
            this.interval = setInterval(() => {
                this.secsCount += 1
            }, 1000)
        },
    }

    const adCloseTimer = {
        secs: 0,
        interval: null,
        start(secs) {
            const close = $('.advertising-close-timer')
            close.removeClass('enabled')
            close.addClass('disabled')

            const timer = $('.advertising-close-timer .timer')
            timer.text(secs)

            this.secs = secs

            this.interval = setInterval(() => {
                this.secs--

                timer.text(this.secs)

                if (this.secs <= 0) {
                    close.addClass('enabled')
                    close.removeClass('disabled')
                    clearInterval(this.interval)
                }
            }, 1000)
        }
    }

    adPopup.ini()
}

$('.advertising-banner, .users-item.add').bind('auxclick click', function () {
    $.post(`/ads/${$(this).data('id')}/click`)
})

//__________________________Verification_________________________//

const resendTimer = {
    secs: 0,
    interval: null,
    start(secs) {
        this.secs = secs
    
        this.interval = setInterval(() => {    
            --this.secs
    
            const formatted = (this.secs - (this.secs %= 60)) / 60 + (9 < this.secs ? ':' : ':0') + this.secs
            $('#countdown').text(formatted)

            if (this.secs <= 0) {
                clearInterval(this.interval)
            }
        }, 1000)
    },
}

function openVerifyPopup(action, verifyUrl, resendUrl, email) {
    const verifyPopup = $('.verification-wrapper')

    verifyPopup.data('action', action)
    verifyPopup.data('verify_url', verifyUrl)
    verifyPopup.data('resend_url', resendUrl)

    verifyPopup.find('.email').text(email)
    
    verifyPopup.addClass('active')

    resendTimer.start(60)
}

$('.code-inputs input').each((index, input) => {
    $(input).on('input', function () {
        if (isNaN(this.value)) {
            this.value = ''
            return
        }

        if (
            this.value.length === 1 &&
            index < $('.code-inputs input').length - 1
        ) {
            $('.code-inputs input').eq(index + 1).focus()
        }
    }).on('keydown', function (e) {
        if (
            e.key === 'Backspace' && 
            index > 0 && 
            this.value === ''
        ) {
            $('.code-inputs input').eq(index - 1).focus()
        }
    })
})

$('.code-inputs input').on('paste', e => {
    e.preventDefault()

    const inputs = $('.code-inputs input')

    let code = (e.originalEvent.clipboardData || window.clipboardData).getData('text')

    code.split('').forEach((number, i) => ! isNaN(number) && $(inputs[i]).val(number))
})

$('.verification-wrapper input').on('input paste', async () => {
    const code = []

    $('.code-inputs input').each((i, input) => input.value && code.push(input.value))

    if (code.length != 6) {
        return
    }

    addLoader('.verification-container')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    const action = $('.verification-wrapper').data('action')
    const verifyUrl = $('.verification-wrapper').data('verify_url')

    const data = `code=${code.join('')}&recaptcha=${await getReCaptchaV3(action)}`

    $.post(verifyUrl, data)
        .done(() => {
            $('.verification-wrapper').removeClass('active')

            $(document).trigger(`${action}-verified`)
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
})

$('.verification-wrapper .again').on('click', async () => {
    if (resendTimer.secs > 0) {
        return
    }

    addLoader('.verification-container')

    $('.code-inputs input').each((i, input) => input.value = '')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    const action = $('.verification-wrapper').data('action')
    const resendUrl = $('.verification-wrapper').data('resend_url')

    const data = `recaptcha=${await getReCaptchaV3(action)}`

    $.post(resendUrl, data)
        .done(() => {
            resendTimer.start(60)
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
})

//__________________________Sign Up_________________________//

$('#sign-up').submit(async function(e) {
    e.preventDefault()
    
    addLoader('.signUP-card')

    const form = $(this)

    const email = form.find('#email')
    email.closest('.input-group').removeClass('error')
    const password = form.find('#password')
    password.closest('.input-group').removeClass('error')
    const error = form.closest('.signUP-card').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('signin')}`

    $.post('/sign-up/send-code', data)
        .done(() => {
            togglePopup('signUp', false)

            openVerifyPopup(
                'sign_up', 
                '/sign-up/verify-code', 
                '/sign-up/resend-code', 
                email.val()
            )
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'email') {
                        email.closest('.input-group').addClass('error')
                        email.next('.error-text').text(errors.email[0])
                    } else if (field == 'password') {
                        password.closest('.input-group').addClass('error')
                        password.next('.error-text').text(errors.password[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.text(xhr.responseJSON.message)
                error.addClass('show')
            }
        }).always(() => {
            removeLoader('.signUP-card')
        })
})

$(document).on('sign_up-verified',() => {
    location.href = '/my-profile'
})

//__________________________Sign In_________________________//

$('#sign-in').submit(async function(e) {
    e.preventDefault()

    addLoader('.logIN-card')

    const form = $(this)

    const email = form.find('#email')
    email.closest('.input-group').removeClass('error')
    const password = form.find('#password')
    password.closest('.input-group').removeClass('error')
    const error = form.closest('.logIN-card').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('signin')}`

    $.post('/sign-in/send-code', data)
        .done(() => {
            togglePopup('logIn', false)

            openVerifyPopup(
                'sign_in', 
                '/sign-in/verify-code', 
                '/sign-in/resend-code', 
                email.val()
            )
        }).fail(xhr => {
            if (xhr.status == 401) {
                password.closest('.input-group').addClass('error')
                password.next('.error-text').text(xhr.responseJSON.message)
            } else if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'email') {
                        email.closest('.input-group').addClass('error')
                        email.next('.error-text').text(errors.email[0])
                    } else if (field == 'password') {
                        password.closest('.input-group').addClass('error')
                        password.next('.error-text').text(errors.password[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.text(xhr.responseJSON.message)
                error.addClass('show')
            }
        }).always(() => {
            removeLoader('.logIN-card')
        })
})

$(document).on('sign_in-verified', () => {
    location.href = '/my-profile'
})

//__________________________Forgot Password_________________________//

$('#forgot-password').submit(async function(e) {
    e.preventDefault()

    addLoader('.resetPassword-card')

    const form = $(this)

    const email = form.find('#reset-email')
    email.closest('.input-group').removeClass('error')
    const error = form.closest('.resetPassword-card').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('forgot')}`

    $.post('/password/forgot', data)
        .done(() => {
            form[0].reset()
            togglePopup('resetPassword', false)

            $('.res-succes-send').find('.mail').text(email.val())
            togglePopup('resSuccesSend', true)
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'email') {
                        email.closest('.input-group').addClass('error')
                        email.next('.error-text').text(errors.email[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.addClass('show')
                error.text(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.resetPassword-card')
        })
})

$('.res-succes-send .btn').click(() => {
    togglePopup('resSuccesSend', false)
})

//__________________________Reset password_________________________//

$('#new-password-form').submit(async function (e) {
    e.preventDefault()

    addLoader('.addNew-pass-card')

    const form = $(this)

    const password = form.find('#new-password')
    password.closest('.input-group').removeClass('error')
    const error = form.closest('.addNew-pass-card').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('forgot')}`

    $.post('/password/reset', data)
        .done(() => {
            form[0].reset()
            togglePopup('addNewPassCard', false)

            togglePopup('passSucces', true)
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'password') {
                        password.closest('.input-group').addClass('error')
                        password.next('.error-text').text(errors.password[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.addClass('show')
                error.text(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.addNew-pass-card')
        })
})

//__________________________Favorites_________________________//

$('.likes').on('click', '.btn', function(e) {
    e.preventDefault()
    e.stopPropagation()

    const likes = $(this)
        .closest('.likes')
        .find('.likes-count')
    const id = $(this).closest('.likes').data('id')

    if ($(this).hasClass('active')) {
        $(this).removeClass('active')
        
        likes.text(parseInt(likes.text()) - 1)

        $.post('/favorites/remove', {favorite_id: id,})
    } else {
        $(this).addClass('active')

        likes.text(parseInt(likes.text()) + 1)
    
        $.post('/favorites/add', {favorite_id: id,})
    }
})

//__________________________Filters_________________________//

$('#filters-form').submit(function() {
    $(this).find('input[name]')
        .filter((i, input) => !input.value)
        .prop('name', '')
})

//__________________________Change options_________________________//

$('#vote-battle, #account-visibility').bind('change', function () {
    const name = $(this).attr('name')
    const value = $(this).prop('checked')

    $.ajax({
        type: 'PATCH',
        url: '/my-profile/switch-option', 
        data: JSON.stringify({name, value}),
        contentType: 'application/json',
    })
})

//__________________________Delete profile_________________________//

$('.delete-acc').click(() => {
    $('#delete-popup').addClass('active')
})

$('#delete-popup #close-popup-btn').click(() => {
    $('#delete-popup').removeClass('active')
})

$('#delete-popup #confirm-delete:not(.load)').click(function () {
    $(this).addClass('load')

    $.ajax({
        type: 'DELETE',
        url: '/my-profile',
    }).then(() => {
        location.href = '/my-profile/create'
    }).catch(jqXHR => {
        alert(jqXHR.responseJSON.message)
        
        $(this).removeClass('load')
    })
})

//__________________________Roulette_________________________//

function initializeBattle($battle) {
    let nextPair = null

    function getNextPair() {
        $.get('/roulette/get-pair').then(res => {
            if (! res.pair) {
                return
            }

            nextPair = res.pair

            const predownloadPhoto = url => {
                const image = new Image 
                image.src = url
            }

            predownloadPhoto(nextPair[0].gallery[0].url)
            predownloadPhoto(nextPair[1].gallery[0].url)
        })
    }

    getNextPair()
    
    function renderNextPair() {
        if (! nextPair) {
            return
        }

        const html = creator => {
            return `
            <div class="photo-container photo" data-id="${creator.id}">
                <img src="${creator.gallery[0].url}">
                <div class="info">
                    ${creator.name.length > 5 ? creator.name.substr(0, 5) + '...' : creator.name}, ${creator.age}
                </div>
            </div>`
        }

        $battle.find('.photo:first').replaceWith(html(nextPair[0]))
        $battle.find('.photo:last').replaceWith(html(nextPair[1]))
    }

    function vote(id) {
        $.post(`/roulette/vote/${id}`)
    }

    const $circle = $battle.find('.progress-ring__circle')
    const radius = $circle[0].r.baseVal.value
    const circumference = 2 * Math.PI * radius

    $circle.css({
        strokeDasharray: circumference,
        strokeDashoffset: circumference,
    })

    let hasSelected = false

    $battle.find('.start_btn').click(function () {
        const $this = $(this)
        $this.closest('.startBattle').addClass('hidden')
        startProgressAnimation($circle, 5000)
        setTimeout(() => activateRepeatButton($this), 5000)
    })

    $battle.on('click', '.photo', function () {
        const $selectedPhoto = $(this);

        if ($selectedPhoto.hasClass('selected')) {
            window.open(`/profile/${$selectedPhoto.data('id')}`, '_blank')
        }

        if (! hasSelected) {
            const $blurredPhoto = $battle.find('.photo').not($selectedPhoto)
            selectPhoto($selectedPhoto, $blurredPhoto)
            hasSelected = true
            vote($selectedPhoto.data('id'))
        } 
    });

    $battle.on('click', '.repeat.active', function () {
        setTimeout(() => {
            renderNextPair()
            hasSelected = false
            getNextPair()
        }, 500)

        const $this = $(this)
        const $loader = $battle.find('.loader')

        $this.removeClass('active')
        $loader.addClass('open')

        setTimeout(() => {
            $loader.removeClass('open')
        }, 1500)

        restartProgressAnimation($circle, 5000)
            setTimeout(() => activateRepeatButton($this), 6500)
        })

        function startProgressAnimation($circle, duration) {
            setTimeout(() => {
                $circle.css({
                    transition: `stroke-dashoffset ${duration / 1000}s linear`,
                    strokeDashoffset: '0',
                })
            }, 0)
        }

        function restartProgressAnimation($circle, duration) {
            $circle.css({
                transition: 'none',
                strokeDashoffset: circumference,
            })

        setTimeout(() => {
            startProgressAnimation($circle, duration)
        }, 1500)
    }

    function activateRepeatButton($button) {
        $button.closest('.battle').find('.repeat').addClass('active')
    }

    function selectPhoto($selectedPhoto, $blurredPhoto) {
        $selectedPhoto.addClass('selected').removeClass('blurred')
        $blurredPhoto.addClass('blurred').removeClass('selected')

        $selectedPhoto.find('.info').text('Click to open profile')
    }
}

$('.battle').each(function () {
    initializeBattle($(this))
})

//__________________________New email_________________________//

$('#change-email-form').submit(async function(e) {
    e.preventDefault()

    addLoader('.enter-new-email')

    const form = $(this)

    const email = form.find('#your-email')
    email.closest('.input-group').removeClass('error')
    const error = form.closest('.enter-new-email').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('change_email')}`

    $.post('/change-email/send-code', data)
        .done(() => {
            form[0].reset()

            togglePopup('newEmail', false)

            openVerifyPopup(
                'change_email', 
                '/change-email/verify-code', 
                '/change-email/resend-code', 
                $('.current.email').text()
            )
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'new_email') {
                        email.closest('.input-group').addClass('error')
                        email.next('.error-text').text(errors.new_email[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.text(xhr.responseJSON.message)
                error.addClass('show')
            }
        }).always(() => {
            removeLoader('.enter-new-email')
        })
})

$(document).on('change_email-verified', () => {
    togglePopup('emailSuccesChanged', true)
})

$('.reset-btn.email').click(() => {
    togglePopup('newEmail', true)
})

$('#pass-succes-changed .btn').click(() => {
    togglePopup('passSuccesChanged', false)
})

//__________________________New password_________________________//

$('#change-password-form').submit(async function(e) {
    e.preventDefault()

    addLoader('.add-new-pass')

    const form = $(this)

    const oldPassword = form.find('#old-password')
    oldPassword.closest('.input-group').removeClass('error')
    const newPassword = form.find('#new-password')
    newPassword.closest('.input-group').removeClass('error')
    const error = form.closest('.enter-new-email').find('.text-error')
    error.removeClass('show')

    const data = form.serialize() + `&recaptcha=${await getReCaptchaV3('change_password')}`

    $.post('/change-password', data)
        .done(() => {
            form[0].reset()

            togglePopup('passSuccesChanged', true)
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                for (const field in errors) {
                    if (field == 'old_password') {
                        oldPassword.closest('.input-group').addClass('error')
                        oldPassword.next('.error-text').text(errors.old_password[0])
                    } else if (field == 'new_password') {
                        newPassword.closest('.input-group').addClass('error')
                        newPassword.next('.error-text').text(errors.new_password[0])
                    } else {
                        error.text(errors[field][0])
                        error.addClass('show')
                    }
                }
            } else {
                error.text(xhr.responseJSON.message)
                error.addClass('show')
            }
        }).always(() => {
            removeLoader('.add-new-pass')
        })
})

$('.reset-btn.pass').click(() => {
    togglePopup('newPass', true)
})

$('#email-succes-changed .btn').click(() => {
    togglePopup('emailSuccesChanged', false)
})