<div class="ps-1 pe-1 pt-5 p-lg-0">
    <!--Top Level of the dashboard content-->
        <div class="container d-flex justify-content-between align-items-center">
            <form action="{{route('car_view')}}" method="GET">
                <button class="btn btn-success me-2">+ Add Car</button>
            </form>
            
            <form action="#" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Car">
                    <button class="input-group-text btn btn-dark">Search</button>
                </div>
            </form>
        </div>
    <!--End-->

    <!--Main Content-->
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-4">
                    <form action="#" method="GET" class="card">
                        <img src="{{asset('Images/Carousel1.jpg')}}" alt="Car Photo">
                        <div class="card-body d-flex flex-column">
                            <h5>Make: Toyota</h5>
                            <p>Model: samplemodel</p>
                            <p>Plate number: ABC1234</p>
                            <button class="btn btn-primary align-self-end">View</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <form action="#" method="GET" class="card">
                        <img src="{{asset('Images/Carousel1.jpg')}}" alt="Car Photo">
                        <div class="card-body d-flex flex-column">
                            <h5>Make: Toyota</h5>
                            <p>Model: samplemodel</p>
                            <p>Plate number: ABC1234</p>
                            <button class="btn btn-primary align-self-end">View</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <form action="#" method="GET" class="card">
                        <img src="{{asset('Images/Carousel1.jpg')}}" alt="Car Photo">
                        <div class="card-body d-flex flex-column">
                            <h5>Make: Toyota</h5>
                            <p>Model: samplemodel</p>
                            <p>Plate number: ABC1234</p>
                            <button class="btn btn-primary align-self-end">View</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <form action="#" method="GET" class="card">
                        <img src="{{asset('Images/Carousel1.jpg')}}" alt="Car Photo">
                        <div class="card-body d-flex flex-column">
                            <h5>Make: Toyota</h5>
                            <p>Model: samplemodel</p>
                            <p>Plate number: ABC1234</p>
                            <button class="btn btn-primary align-self-end">View</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <form action="#" method="GET" class="card">
                        <img src="{{asset('Images/Carousel1.jpg')}}" alt="Car Photo">
                        <div class="card-body d-flex flex-column">
                            <h5>Make: Toyota</h5>
                            <p>Model: samplemodel</p>
                            <p>Plate number: ABC1234</p>
                            <button class="btn btn-primary align-self-end">View</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <form action="#" method="GET" class="card">
                        <img src="{{asset('Images/Carousel1.jpg')}}" alt="Car Photo">
                        <div class="card-body d-flex flex-column">
                            <h5>Make: Toyota</h5>
                            <p>Model: samplemodel</p>
                            <p>Plate number: ABC1234</p>
                            <button class="btn btn-primary align-self-end">View</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!--End-->
</div>