@auth('web')
<a href="{{ route('info.page') }}" class="btn red meow balance">
    <img src="{{ asset('/assets/img/MeowIcon.svg') }}" class="meowicon" alt="" />
    <span class="balance-2 rich">
        {{ ($balace2Total = auth('web')->user()->balance_2_total) >= 100 ? 'Rich' : format_price($balace2Total) }}
    </span>
</a>
@endauth

@guest('web')
<div class="btn red meow" data-step="0">
    Click :)
</div>

<script>
    const meowText = [
        '14',
        '13',
        'noon',
        '11',
        '10',
        'MORE !!!',
        '8',
        '007',
        'moree??',
        '50%',
        '4',
        '3',
        '2',
        '1',
        '0',
        '-1 ;D',
        'secret',
        'more!',
        '-4',
        'doNe',
    ]

    const meowAudio = [
        '/assets/meow/1.mp3',
        '/assets/meow/2.mp3',
        '/assets/meow/3.mp3',
        '/assets/meow/4.mp3',
        '/assets/meow/5.mp3',
        '/assets/meow/6.mp3',
        '/assets/meow/7.mp3',
        '/assets/meow/8.mp3',
        '/assets/meow/9.mp3',
        '/assets/meow/10.mp3',
        '/assets/meow/11.mp3',
        '/assets/meow/12.mp3',
        '/assets/meow/13.mp3',
        '/assets/meow/14.mp3',
        '/assets/meow/15.mp3',
        '/assets/meow/16.mp3',
        '/assets/meow/17.mp3',
        '/assets/meow/18.mp3',
        '/assets/meow/19.mp3',
        '/assets/meow/20.mp3',
        '/assets/meow/21.mp3',
    ]
    new Audio(meowAudio[0])

    window.onload = () => {
        let currentAudio = null

        $('.meow.btn').on('click', function () {
            const step = Number($(this).data('step'))

            if (step <= 20) {
                $(this).text(meowText[step])

                currentAudio?.pause()
                currentAudio = new Audio(meowAudio[step])
                currentAudio.play()
            } 

            if (step == 20) {
                $(currentAudio).on('ended', () => location.href = '/faq#some-funny-feature')
            }

            const nextStep = step + 1
            
            $(this).data('step', nextStep)

            new Audio(meowAudio[nextStep])
        })
    }
</script>
@endguest