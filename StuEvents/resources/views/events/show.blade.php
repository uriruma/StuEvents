<!-- Show details of a specific event -->
<h1>Event Details</h1>

<table class="table">
    <tbody>
        <tr>
            <th>ID</th>
            <td>{{ $event->id }}</td>
        </tr>
        <tr>
            <th>Title</th>
            <td>{{ $event->title }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $event->description }}</td>
        </tr>
        <tr>
            <th>Location</th>
            <td>{{ $event->location }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $event->date }}</td>
        </tr>
    </tbody>
</table>

<a href="{{ route('events.index') }}" class="btn btn-primary">Back to List</a>
