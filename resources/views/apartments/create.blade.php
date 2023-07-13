

<form action="{{route('apartments.store')}}" method="POST">
    @csrf


    {{-- Title --}}
    <div class="mb-3">
        <label class="form-label">Titolo</label>
        <input type="text"
        class="form-control w-75
        id="title"
        name="title"
        placeholder="Inserisci un titolo">
    </div>

    {{-- Price --}}
    <div class="mb-3">
        <label class="form-label">Prezzo</label>
        <input type="number"
        class="form-control w-75
        id="price"
        name="price"
        placeholder="Inserisci un titolo">
    </div>

    {{-- Category --}}
    <div class="mb-3">
        <label class="form-label">Categoria</label>
        <input type="text"
        class="form-control w-75
        id="title"
        name="category"
        placeholder="Inserisci categoria">
    </div>

    {{-- Address --}}
    <div class="mb-3">
        <label class="form-label">Indirizzo</label>
        <input type="text"
        class="form-control w-75
        id="address"
        name="address"
        placeholder="Inserisci l'indirizzo">
    </div>

    {{-- Number of rooms --}}
    <div class="mb-3">
        <label class="form-label">Numero stanze</label>
        <input type="number"
        class="form-control w-75
        id="n_rooms"
        name="n_rooms">
    </div>

    {{-- Number of beds --}}
    <div class="mb-3">
        <label class="form-label">Numero letti</label>
        <input type="number"
        class="form-control w-75
        id="n_beds"
        name="n_beds">
    </div>

    {{-- Number of bathrooms --}}
    <div class="mb-3">
        <label class="form-label">Numero bagni</label>
        <input type="number"
        class="form-control w-75
        id="n_bathrooms"
        name="n_bathrooms">
    </div>


</form>
