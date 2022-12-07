@include('shared.pagination')
<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">ID#</th>
        <th scope="col">Photo</th>
        <th scope="col">Name</th>
        @if($type === 'admins')
        <th scope="col">Is Super Admin</th>
        @endif
        <th scope="col">Email</th>
        <th scope="col">Age</th>
        <th scope="col">Gender</th>
        <th scope="col">Contact No.</th>
        <th scope="col">Date of Birth</th>
        <th scope="col">Status</th>
        <th scope="col">Deleted At</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $data)
      <tr>
        <td>{{ $data->id }}</td>
        <td>
            <a href="{{ $data->photo }}" data-lightbox="image-{{ $data->id }}" class="text-dark text-decoration-none">
                <img src="{{ $data->photo }}" style="width: 70px;">
            </a>
        </td>
        <td>{{ $data->first_name }} {{ $data->last_name }}</td>
        @if($type === 'admins')
        <td>{{ $data->is_super ? 'Yes' : 'No' }}</td>
        @endif
        <td>{{ $data->email ?? 'N/A' }}</td>
        <td>{{ \Carbon\Carbon::parse($data->date_of_birth)->diff(\Carbon\Carbon::now())->y}}</td>
        <td>{{ $data->gender ?? 'N/A' }}</td>
        <td>{{ $data->contact_no ?? 'N/A' }}</td>
        <td>{{ $data->date_of_birth ?? 'N/A' }}</td>
        <td>{{ $data->deleted_at ? 'Deleted' : $data->status }}</td>
        <td>{{ $data->deleted_at ?? 'N/A' }}</td>
        <td>
          <div class="d-flex justify-content-center">
            @if($type === 'teachers')
              @include('shared.view-company')
            @endif
            @if($data->deleted_at)
              @include('shared.restore-item', ['class' => '', 'type' => $type, 'id' => $data->id, 'url' => route('user.restore')])
            @else
              @include('shared.edit-user', ['type' => $type])
              @include('shared.delete-item', ['class' => '', 'type' => $type, 'id' => $data->id, 'url' => route('user.delete')])
            @endif
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@include('shared.pagination')