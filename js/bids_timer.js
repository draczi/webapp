
putspan(ForeColor);
var countDownDate = new Date(TargetDate);
var nowDate = new Date();
different = new Date(countDownDate-nowDate);
secs = Math.floor(different.valueOf()/1000);
CountBack(secs);

function CountBack(secs) {
    if (secs < 0) {
        $('#bids').hide();
        $('.lezarult').show();
        document.getElementById("auction_end").innerHTML = FinishMessage;
        return;
    }

    DisplayStr = DisplayFormat.replace(/%%D%%/g, Math.floor(different / (1000 * 60 * 60 * 24)));
    DisplayStr = DisplayStr.replace(/%%H%%/g, Math.floor((different % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
    DisplayStr = DisplayStr.replace(/%%M%%/g, Math.floor((different % (1000 * 60 * 60)) / (1000 * 60)));
    DisplayStr = DisplayStr.replace(/%%S%%/g, Math.floor((different  % (1000 * 60)) / 1000));

    document.getElementById("auction_end").innerHTML = DisplayStr;
    if (CountActive)
    setTimeout("CountBack(" + secs + ")", 1000);

    }

    function putspan(forecolor) {
    document.write("<span id='"+forecolor+"' style='color: #000; font-weight: 200; font-size: 15px '>");

}
