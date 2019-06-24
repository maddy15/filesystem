@extends('layouts.app')

@section('styles')
    <style>
        #heroHead
        {
            opacity : 0;
            transform: scaleY(0);
            transform-origin: 0 0;
        }

        #box1
        {
            width: 100%;
            height: 100%;
            background: #fc3;
            position: absolute;
            left: 50%;
            top: 50%;
            opacity: 0;
            transform: translate(-50%,-50%) scale(0);
            /* transform: scale(0); */
        }
    </style>
@stop

@section('content')
<section style="position:relative">
    <div id="box1" class="is-primary"></div>
    <section class="hero is-medium is-primary is-bold" id="heroHead">
        <div class="hero-body">
            <div class="container">
            <h1 class="title">
                Primary bold title
            </h1>
            <h2 class="subtitle">
                Primary bold subtitle
            </h2>
            </div>
        </div>
    </section>
</section>
@stop

@section('scripts')
    <script>
        $(document).ready(() => {
            var tl = TweenLite.TweenLite;
            // console.log(GreenSock);
            tl.to('#box1',1,{
                opacity : 1,
                transform: 'translate(-50%,-50%) scale(1)',
                // ease: SlowMo.ease.config(0.7, 0.7, false),
                ease: CustomEase.create("custom", "M0,0.556,C0.123,0.642,0.209,1.05,0.235,1.05,0.31,1.047,0.408,0.572,0.783,0.306,1.499,-0.202,0.37,1.186,1,1.164")
            })

            tl.to('#heroHead',1,{
                opacity : 1,
                transform: 'scaleY(1)'
            }).delay(1);
        });
    </script>
@stop