<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="/Public/mobile/js/common.js"></script>
    <link rel="stylesheet" href="/Public/mobile/css/vant.css">
    <script src="/Public/mobile/js/vant/dist/vue.min.js"></script>
    <script src="/Public/mobile/js/vant/lib/vant.min.js"></script>
    <script src="/Public/mobile/js/vue-resource.js"></script>
    <script src="/Public/js/jquery.min.js"></script>
    <!-- 引入组件 -->
    <script src="/Public/mobile/components/comp-input.js"></script>
    <script src="/Public/mobile/components/comp-datetime.js"></script>
    <script src="/Public/mobile/components/comp-address.js"></script>
    <script src="/Public/mobile/components/comp-checkbox.js"></script>
    <script src="/Public/mobile/components/comp-radio.js"></script>
    <script src="/Public/mobile/components/comp-select.js"></script>
    <script src="/Public/mobile/js/util.js"></script>

</head>

<body>
<div id="dcontent" class="dcontent">
    <form id="formData">
        #controll#
    </form>
    <van-button size="large" type="primary" @click="push">保存</van-button>
    <a href="__APP__/MobileList/logout">退出</a>
</div>
<div id="output">
</div>
</body>
