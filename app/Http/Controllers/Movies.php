<?php

namespace App\Http\Controllers;

use App\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Movies extends Controller
{
    /**
     * Grab all movies
     *
     * @return Response
     */
    public function index()
    {
        return Movie::orderBy('id', 'asc')->get();
    }

    /**
     * Save a new movie
     *
     * @param  Request  $request
     * @return Response|string
     */
    public function create(Request $request)
    {
        try
        {
            $this->validate($request, Movie::rules());
        }
        catch (ValidationException $e)
        {
            return response($e->validator->getMessageBag(), 400);
        }

        try
        {
            $movie = Movie::create(array(
                'title' => $request->input('title'),
                'format' => $request->input('format'),
                'length' => $request->input('length'),
                'year' => $request->input('year'),
                'rating' => $request->input('rating') ?: null
            ));

            if ($movie->save())
            {
                return response($movie, 201);
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Return a specific movie by id
     *
     * @param  int  $id
     * @return Response
     */
    public function get($id)
    {
        return Movie::find($id);
    }

    /**
     * Update the specified movie
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $this->validate($request, Movie::rules());
        }
        catch (ValidationException $e)
        {
            return response($e->validator->getMessageBag(), 400);
        }

        $movie = Movie::find($id);
        $movie->title = $request->input('title');
        $movie->format = $request->input('format');
        $movie->length = $request->input('length');
        $movie->year = $request->input('year');
        $movie->rating = $request->input('rating') ?: null;

        try
        {
            if ($movie->save())
            {
                return response($movie, 200);
            }
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response($e->getMessage(), 500);
        }

        return response($movie, 200);
    }

    /**
     * Delete a movie by id
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        try
        {
            // Load the movie
            $movie = Movie::find($id);

            // If it doesn't already exist throw a 404 in case the calling application needs to know it
            // wasn't there to begin with
            if ($movie == null)
            {
                return response(null, 404);
            }

            $movie->delete();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response($e->getMessage(), 500);
        }

        return response(null, 204);
    }
}
