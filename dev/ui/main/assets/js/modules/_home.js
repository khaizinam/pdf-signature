class Home{
    constructor(){
        this.events();
    }
    events(){
        this.menuBar();
    }
    menuBar(){
        $(document).on('click', '.ajax-open-menu',function(){
            $('#menu-bar').toggleClass("active");
        })
    }
}
export default Home;
