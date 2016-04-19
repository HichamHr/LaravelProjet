/**
 * Created by Charif on 01/04/2016.
 */
$(document).ready(function(){
    $('.switchUl li').click(function(){
        $('.switchUl li').removeClass('active');
        if(this.className != "active"){
            this.className = "active";
        }
    });
});
