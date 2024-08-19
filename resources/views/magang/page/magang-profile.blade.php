@include('Admin.layout.header')
@include('Magang.layout.sidebar')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Magang / Profile Peserta /</span>
            {{ auth()->user()->name }}</h4>
        <div class="row">
            <div class="col-lg-4 mb-4 order-0">
                <div class="card text-center">
                    <h5 class="card-header">
                        Profile Picture
                    </h5>
                    <hr class="m-0">
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="text-center">
                                        <img src="{{ auth()->user()->foto_profile ? asset('storage/' . auth()->user()->foto_profile) : asset('assets/img/blank-profile.png') }}"
                                            class="rounded-circle img-thumbnail" width="150" height="150"
                                            alt="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5
                                        MB
                                    </div>
                                </div>
                                <input class="form-control" type="file" id="formFile" />
                                <button class="btn btn-primary" type="button">Upload new image</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Admin.Layout.footer')
