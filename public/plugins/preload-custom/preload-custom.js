function  CustomPreload() {

    CustomPreload.prototype.show = function (elementId = null) {
     
        var element = elementId ? "#" + elementId : 'body';
        if(elementId) {
            var preloadElement = elementId + '-load';
            $(element).append('<div class="contenier-loading element-loading" id="' + preloadElement + '"style="background : rgba(0, 0, 0, 0.3) !important;"> <div class="signal"></div ></div>');
        }else{
             $('body').append('<div class="contenier-loading" id="body-load" style="background : rgba(0, 0, 0, 0.3) !important;"> <div class="signal"></div ></div>');
        }
    };
    
    CustomPreload.prototype.hide = function (elementId = null) {
        setTimeout(function () {
            var preloadElement = elementId ? elementId : 'body';
            $("#" + preloadElement + '-load').detach();
        }, 100);
    }
}

var CustomPreload = new CustomPreload();

window.onload = function () {
    CustomPreload.hide();
};