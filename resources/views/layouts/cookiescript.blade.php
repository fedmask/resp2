<script>
    function accept(){
        document.cookie="consent="+today()+";expires="+new Date(new Date().setFullYear(new Date().getFullYear() + 1))+";";
        let cookies = document.getElementById("cookies");
        cookies.remove();
        window.location.reload()
        
    }

    function refuse(){
        let cookies = document.getElementById("cookies");
        document.cookie="consent=;";
        cookies.remove();
       
    }

    function today(){
        let today = new Date();
        let dd = today.getDate() < 10 ? '0'+today.getDate():today.getDate();
        let mm = (today.getMonth()+1) < 10 ? '0'+today.getMonth():today.getMonth();
        let yyyy = today.getFullYear();
        let hh = today.getHours();
        let min = today.getMinutes() < 10 ? '0'+today.getMinutes():today.getMinutes();
        let sec = today.getSeconds() < 10 ? '0'+today.getSeconds():today.getSeconds();
        return dd+'/'+mm+'/'+yyyy+' - '+hh+':'+min+':'+sec;
    }
</script>