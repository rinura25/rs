<template>
    <section class="content">
        <!-- Default box -->
        <div class="card-body">
            <section class="content">
                <div class="col-md">
                    <form action="/pasien" method="GET">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search NIK Pasien. . . " name="nik">
                            <button class="btn btn-danger" type="submit">search</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <div class="container">
            <table class="table">
                <thead class="thead-dark" align="center">
                    <tr>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Bahasa</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <tr>
                        <!-- <td> {{ $request->namaPasien }} </td>
                        <td> {{ $request->gender }} </td>
                        <td> {{ $request->bahasa }} </td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>