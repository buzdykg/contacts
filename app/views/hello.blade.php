<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel PHP Framework</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css"/>
	<style>
		/* basic styling */
		td {
			font-size: 12px;
			padding: 2px 4px;
			border: 1px solid #eee;
		}
		td.error {
			background-color: rgba(255, 0, 0, 0.3);
		}

		div.title {
			font-size: 24px;
			margin: 10px 0 10px 0;
		}

		.about {
			font-size: 12px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row about">
			<div class="col-md-4">
				<div class="title">About</div>
				<ol>
					<li>If a job service field contains comma - the row is splitted to several rows;</li>
					<li>Every value is normilized. E.g. trimmed or state name changed to state code;</li>
					<li>Field validation;</li>
					<li>Fields with hard failures get their values restored to original;</li>
					<li>My <a href="/test.csv" target="_blank">test.csv</a>.</li>
				</ol>
			</div>
			<div class="col-md-4 col-md-push-2">
				<div class="title">Thoughts and todos</div>
				<ol>
					<li>Accessing csv by index is tricky. It's better to convert it to associative array;</li>
					<li>It's better to make Normilizer and Validator use json configs instead of subclassing.</li>
				</ol>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-push-4">
				<div class="title">CSV upload form</div>
				<form action="" enctype="multipart/form-data" method="POST">
					<input type="file" name="csv"/>
					<input type="submit" value="upload"/>
				</form>
			</div>
		</div>
		@if (isset($processedData))
		<div class="row">
			<div class="title">Processed data</div>
			<div class="col-md-10 col-md-offset-1">
				<table>
					<tr>
						<td>First Name</td>
						<td>Last Name</td>
						<td>Email</td>
						<td>Phone</td>
						<td>Street</td>
						<td>City</td>
						<td>State</td>
						<td>Job service</td>
						<td>Price</td>
						<td>Cycle In</td>
						<td>Next Job Date</td>
					</tr>
					@foreach ($processedData as $row)
						<tr>
						@for ($i = 0; $i <= 11; $i++)
							<td @if (isset($row[12]) && array_search($i, $row[12]) !== false) class="error" @endif>
								@if (isset($row[$i]))
								{{{$row[$i]}}}
								@endif
							</td>
						@endfor
						</tr>
					@endforeach
				</table>
			</div>
		</div>
		@endif

		@if (isset($originalData))
			<div class="row">
				<div class="title">Original data</div>
				<div class="col-md-10 col-md-offset-1">
					<table>
						<tr>
							<td>First Name</td>
							<td>Last Name</td>
							<td>Email</td>
							<td>Phone</td>
							<td>Street</td>
							<td>City</td>
							<td>State</td>
							<td>Zip Code</td>
							<td>Job service</td>
							<td>Price</td>
							<td>Cycle In</td>
							<td>Next Job Date</td>
						</tr>
						@foreach ($originalData as $row)
							<tr>
								@for ($i = 0; $i <= 10; $i++)
									<td>
										{{{$row[$i]}}}
									</td>
								@endfor
							</tr>
						@endforeach
					</table>
				</div>
			</div>
		@endif
	</div>
</body>
</html>
