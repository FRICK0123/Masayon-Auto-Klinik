<div class="container w-75 border border-2 shadow pt-3 pb-3">
    <h2 class="text-center">Add New Car</h2>
    <form action="#" method="post" class="container">
        <div class="profile_img_wrapper mt-5">
            <img src="{{ asset('icons/car.svg') }}" alt="Profile Image" class="profile_image">
        </div><br><br>
        
        <label for="car_make" class="fw-bold">Car Make:</label>
        <input type="text" placeholder="Honda, Ford, Mitsubishi, etc." name="car_make" class="form-control" id="car_make"><br>

        <label for="car_model" class="fw-bold">Car Model:</label>
        <input type="text" placeholder="Honda Civic, Ford Ranger, Mitsubishi Montero Sport, etc." name="car_make" class="form-control" id="car_model"><br>

        <label for="year_of_manufacture" class="fw-bold">Year of Manufacture:</label>
        <select name="year_of_manufacture" id="year_of_manufacture" class="form-select">
            <option value="">Select Year</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
            <option value="2021">2021</option>
            <option value="2020">2020</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
            <option value="2017">2017</option>
            <option value="2016">2016</option>
            <option value="2015">2015</option>
            <option value="2014">2014</option>
            <option value="2013">2013</option>
            <option value="2012">2012</option>
            <option value="2011">2011</option>
            <option value="2010">2010</option>
            <option value="2009">2009</option>
            <option value="2008">2008</option>
            <option value="2007">2007</option>
            <option value="2006">2006</option>
            <option value="2005">2005</option>
            <option value="2004">2004</option>
            <option value="2003">2003</option>
            <option value="2002">2002</option>
            <option value="2001">2001</option>
            <option value="2000">2000</option>
            <option value="1999">1999</option>
            <option value="1998">1998</option>
            <option value="1997">1997</option>
            <option value="1996">1996</option>
            <option value="1995">1995</option>
            <option value="1994">1994</option>
            <option value="1993">1993</option>
            <option value="1992">1992</option>
            <option value="1991">1991</option>
            <option value="1990">1990</option>
        </select><br>

        <label for="plate_number" class="fw-bold">Plate Number:</label>
        <input type="text" placeholder="ABC 123" name="plate_number" class="form-control" id="plate_number"><br>

        <button class="btn btn-dark">Submit</button>
    </form>
</div>