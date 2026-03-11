<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller
{public function index(): JsonResponse
  {
  $categories = Category::withCount('books')->get();
  return response()->json([
  'status' => 'success',
  'data' => $categories
  ]);
  }
 
  // POST /api/categories
  public function store(Request $request): JsonResponse
  {
  $validated = $request->validate([
  'name' => 'required|string|max:255',
  'desc'=> 'required|string'
  ]);
 
  $category = Category::create($validated);
 
  return response()->json([
  'status' => 'success',
  'message' => 'Catégorie créée avec succès',
  'data' => $category
  ], 201);
  }

public function show(Category $category): JsonResponse
  {
  $category->load('books');
  return response()->json([
  'status' => 'success',
  'data' => $category
  ]);
  }
 
  // PUT /api/categories/{id}
  public function update(Request $request, Category $category): JsonResponse
  {
  $validated = $request->validate([
  'name' => 'sometimes|required|string|max:255',
  'desc' => 'sometimes|string',
  ]);
 $category->update($validated);
 
  return response()->json([
  'status' => 'success',
  'message' => 'Catégorie mise à jour',
  'data' => $category
  ]);
  }
public function destroy(Category $category): JsonResponse
  {
  $category->delete();
  return response()->json([
  'status' => 'success',
  'message' => 'Catégorie supprimée'
  ]);
  }
 

  public function books(Category $category): JsonResponse
  {
  return response()->json([
  'status' => 'success',
  'data' => $category->books
  ]);
  }
}
