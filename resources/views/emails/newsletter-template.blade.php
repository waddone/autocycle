<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Autocycle newsletter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<style>

.emailTemplate {
    border:3px solid #c4161c;
    margin-top: 30px;
    width: 100%;
    border-collapse: inherit;
}
.emailTemplate td {
    width: 100%;
    display: block;
}
.LogoMail {
    text-align:center; 
    width: 100%;
    padding: 15px;
    border-bottom: 1px solid #ccc;
}
.LogoMail img{
    margin: 0 auto !important;
    height: 60px;
}
.titluMail {
    font-size: 15px;
    color:#c4161c;
    padding: 15px;
    padding-bottom: 5px;
    padding-top: 5px;
    border-bottom: 1px solid #ccc;
}
.textMail {
    padding:15px;
    color:666;
    font-size: 14px;
    padding-top: 25px;
}
.textMail textarea {
    width: 100%;
    min-height: 200px;
}
.FooterLogoMail {
    background-color: #000;
    padding: 7.5px;
    padding-left: 15px;
    color:#fff;
    line-height: 40px;
}
.FooterLogoMail img{
    height: 40px;
}
.FooterLogoMail span{
    padding-left: 15px;
    font-size: 14px;
}
.PrezenareEmail {
    font-size: 15px;
    color:#000;
    padding: 15px;
    font-weight: bold;
}
</style>
<body style="margin: 0; padding: 0;">
    <table class="emailTemplate">
        <tr class="text-center">
            <td class="text-center LogoMail">
                <img src="{{ url('/') }}/resources/assets/images/logo.png" alt="Autocycle">  
                <br/>
                Autocycle.ro | autodezmembrat.ro
            </td>
            <td class="text-left titluMail">
                {{ $titluEmail }}
            </td>
            <td class="text-left PrezenareEmail">
                Buna ziua {{ $userName }} ,
            </td>
            <td class="text-left textMail">
                {{ $textNewsletter }}
            </td>
            <td class="text-left FooterLogoMail">
                <img src="{{ url('/') }}/resources/assets/images/logo_white.png" alt="Autocycle">  
                <span>@Autocycle.ro | @autodezmembrat.ro - 2018 </span>
            </td>
        </tr>
    </table>
</body>
</html>