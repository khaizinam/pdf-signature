
<section class="no-mg-top">
<div class="container banner-header">
    <img src="{{ Theme::asset()->url('images/banner-1.jpg') }}" alt="banner">
    <div class="bg-linear"></div>
</div>

<div class="container body-content-top">
    <div class="border-radius-circle avatar">
    <img src="{{Theme::asset()->url('images/avatar-1.jpg')}}" alt="avatar">
    </div>

    <div class="content-box-top">
    <a
        href="https://www.facebook.com/undefined.200114071004/"
        class="user-name"
        target="_blank"
        title="facebook">Undefined Khai</a>
    <h3 class="title-head">Software Developer</h3>
    <hr>
    <a
        class="get-latest-cv"
        href="{{Theme::asset()->url('files//NGUYEN_HUU_KHAI_CV.pdf')}}"
        download="NGUYEN_HUU_KHAI_CV.pdf"
        ><i class="fa-solid fa-file-arrow-down"></i> Get my latest CV</a>
    </div>

</div>
</section>

<section class="pb-32">
<div class="container body-content bg-color-wash">
    <article>
    <h4 class="header-section"><i class="fa-solid fa-scroll"></i> About me</h4>
    <p>
        "I am a software developer since Aug 2022 in developing and maintaining web applications.
        I am passionate about building innovative and user-friendly products,
        and I have a proven track record of success in delivering high-quality projects on time and within budget.
        I am currently seeking a new opportunity to use my skills and experience to make a positive impact on a company's bottom line."
    </p>
    </article>

    <h3 class="text-underline"><i class="fa-solid fa-wand-sparkles"></i> EDUCATION</h3>
    <div class="edu-row-content">
    <a
        href="https://hcmut.edu.vn/"
        target="_blank"
        class="logo-edu"><img src="{{Theme::asset()->url('images/HCMUT_official_logo.png')}}" alt="logo hcmut">
    </a>
    <div class="edu-right-content">
        <a
        href="https://hcmut.edu.vn/"
        target="_blank"
        class="Platypi-Bold mb-10" title="HCMUT">Ho Chi Minh CITY University of Technology (Bach Khoa)</a>
        <p>Major: Computer Science</p>
        <p>Aug, 2019 - Nov, 2024</p>
    </div>
    </div>
</div>
</section>

<section id="projects">
<div class="container">
    <h3>My Experiences</h3>
    <br>
    <h4>Landing Page</h4>

    <ul class="list-layout">

    <li>
        <div class="card-project">
        <div class="card-thumb">
            <img src="{{Theme::asset()->url('images/projects/seltos-banner.jpg')}}" alt="newseltos-banner">
            <a
            href="https://newseltos.kiavietnam.com.vn"
            target="__blank"
            class="layer-link"
            >
            <i class="fa-solid fa-link"></i>
            </a>
        </div>
        <div class="card-body cusor-pointer" >
            <h3 class="fs-14px">KiaVietNam</h3>
            <h4 class="fs-16px fw-bold">New Seltos 2024</h4>
            <div class="fs-14px" style="margin-top: 5px;">
            <span class="dot">Live</span>,
            <span class="tag-item laravel">Laravel</span>,
            <span class="tag-item mysql">MySQL</span>
            </div>
        </div>
        </div>
    </li>

    <li>
        <div class="card-project">
        <div class="card-thumb">
            <img src="{{Theme::asset()->url('images/projects/new-sonet.jpg')}}" alt="newsonet-banner">
            <a
            href="https://newsonet.kiavietnam.com.vn"
            target="__blank"
            class="layer-link"
            >
            <i class="fa-solid fa-link"></i>
            </a>
        </div>
        <div class="card-body cusor-pointer">
            <h3 class="fs-14px">KiaVietNam</h3>
            <h4 class="fs-16px fw-bold">New Sonet 2024</h4>
            <div class="fs-14px" style="margin-top: 5px;">
            <span class="dot">Live</span>,
            <span class="tag-item laravel">Laravel</span>,
            <span class="tag-item mysql">MySQL</span>
            </div>
        </div>
        </div>
    </li>

    <li>
        <div class="card-project">
        <div class="card-thumb">
            <img src="./asset/images/projects/new-carnival.jpg" alt="carnival-banner">
            <a
            href="https://newcarnival.kiavietnam.com.vn"
            target="__blank"
            class="layer-link"
            >
            <i class="fa-solid fa-link"></i>
            </a>
        </div>
        <div class="card-body cusor-pointer">
            <h3 class="fs-14px">KiaVietNam</h3>
            <h4 class="fs-16px fw-bold">New Carnival 2024</h4>
            <div class="fs-14px" style="margin-top: 5px;">
            <span class="dot">Live</span>,
            <span class="tag-item laravel">Laravel</span>,
            <span class="tag-item mysql">MySQL</span>
            </div>
        </div>
        </div>
    </li>

    <li>
        <div class="card-project">
        <div class="card-thumb">
            <img src="./asset/images/projects/lagoona.jpg" alt="lagoona-banner">
            <a
            href="https://harmony.lagoonabinhchau.com"
            target="__blank"
            class="layer-link"
            >
            <i class="fa-solid fa-link"></i>
            </a>
        </div>
        <div class="card-body cusor-pointer">
            <h3 class="fs-14px">DAT GIA REAL ESTATE</h3>
            <h4 class="fs-16px fw-bold">Zone B Lagoona Bình Châu</h4>
            <div class="fs-14px" style="margin-top: 5px;">
            <span class="dot">Live</span>,
            <span class="tag-item laravel">Laravel</span>,
            <span class="tag-item mysql">MySQL</span>,
            <span class="tag-item mysql">FullPage</span>
            </div>
        </div>
        </div>
    </li>

    </ul>

    <br>
    <h4>Development</h4>

    <ul class="list-layout" id="post-development">
    </ul>

    <!-- <br> -->
    <!-- <h4>Maintenance</h4>

    <ul class="list-layout">

    </ul> -->
</div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        ...
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
    </div>
</div>
</div>

<div class="footer">

</div>
