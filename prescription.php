<link rel="stylesheet" href="css/bootstrap.min.css">

<style>
    .table {
        max-width: 400px;
        margin-bottom: 0;
    }
</style>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">
            <p>Patient's name</p>
            <p>DOB</p>
            <p>CHI no</p>
        </th>
    </tr>
    </thead>
</table>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col" style="text-align: center">Medication Required</th>
    </tr>
    </thead>
</table>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Strength</th>
        <th scope="col">Quantity</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Gentamicin</td>
        <td>0.75g</td>
        <td>Quantity</td>
    </tr>
    </tbody>
</table>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">
            <p>Doctor's Name</p>
            <p>Registration No: ________________________</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature: ________________________</p>
        </th>
    </tr>
    </thead>
</table>

<script>
    window.print();
    setTimeout(window.close, 0); // this will close the page when user clicks on cancel (edge does not work)
</script>