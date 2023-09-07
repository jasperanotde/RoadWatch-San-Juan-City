@extends('layout.layout')

@section('content')
<table style="margin-top: 100px" class="mb-10 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead style="border-bottom: 1px solid gray" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        
                    <th scope="col" class="px-6 py-3">
                            No.
                        </th>
                        <th scope="col" class="px-6 py-3">
                           Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                           Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Roles
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
 		@foreach ($data as $key => $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                           {{ ++$i }}	
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                             @if(!empty($user->getRoleNames()))
      			  @foreach($user->getRoleNames() as $v)
           		<label class="badge badge-success">{{ $v }}</label>
       			 @endforeach
    			  @endif
                        </td>
                        <td class="px-6 py-4">
                             <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
       			   <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
       			 {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
           		 {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
       			 {!! Form::close() !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                {!! $data->render() !!}
        </div>
        <script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>
    </div>
</div>
@endsection