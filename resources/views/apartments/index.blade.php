<div class="container py-5">
    <h1>Appartamenti</h1>
        <table class="table my-3">
            <thead>
                <tr>
                    <th scope="col">Titolo</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Indirizzo</th>
                    <th scope="col">Stanze</th>
                    <th scope="col">Letti</th>
                    <th scope="col">Bagni</th>
                    <th scope="col">Metri quadrati</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Dettagli</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                    <tr>
                        <td>{{$apartment->title}}</td>
                        <td>{{$apartment->category}}</td>
                        <td>{{$apartment->address}}</td>
                        <td>{{$apartment->n_rooms}}</td>
                        <td>{{$apartment->n_beds}}</td>
                        <td>{{$apartment->n_bathrooms}}</td>
                        <td>{{$apartment->square_meters}}</td>
                        <td>{{$apartment->price}}</td>
                        <td>
                            <a href="{{route('apartments.show', $apartment)}}" class="btn btn-primary">Vai</a>
                        </td>
                    </tr>
                    @endforeach
                    <a href="{{route('apartments.create')}}" class="btn btn-primary">Crea appartamento</a>
            </tbody>
        </table>
</div>


