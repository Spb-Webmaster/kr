<div class="slider_slider" style="background-image: url({{ Storage::url('images/slider/kr-slider.jpg') }})">
<div class="flex">
    <div class="left">
        <h1 class="title">{{ config2('moonshine.home.title') }}</h1>
        <div class="subtitle">{{ config2('moonshine.home.sub_title') }}</div>
<div class="border"></div>
     <div class="box1">
         <div class="phone"><i></i> {{ format_phone(trim(config2('moonshine.setting.phone'))) }}</div>
         <div class="email"><i></i> {{ config2('moonshine.setting.email') }}</div>
     </div>
<div class="box2">
         <div class="address">{!!  config2('moonshine.setting.address_top') !!}</div>
     </div>
    </div>
    <div class="right"></div>
</div>
</div>
