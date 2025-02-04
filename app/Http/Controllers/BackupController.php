<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class BackupController extends Controller
{
    // List all backups
    public function index()
    {
        // Get a list of backup files from the local disk (or the configured disk)
        $files = File::files(storage_path('app/private/Laravel'));
        return Inertia::render('Backups/Index', ['files' => $files]);
    }

    // Create a new backup
    public function create()
    {
        $exitCode = Artisan::call('backup:run');
        return redirect()->route('backups.index')->with('success', 'Backup created successfully.');
    }


    // Restore a backup
    public function restore(Request $request)
    {
        // Validate the file input
        $file = $request->input('file');
        $filePath = 'Laravel/' . $file; // Path inside the backups disk

        if (!Storage::disk('backups')->exists($filePath)) {
            return redirect()->route('backups.index')->with('error', 'Backup file not found.');
        }

        // Get the full path of the backup file
        $backupFullPath = Storage::disk('backups')->path($filePath);

        // Define the temporary extraction path
        $tempPath = storage_path('app/temp-restore');

        // Create a temporary directory if it doesn't exist
        if (!File::exists($tempPath)) {
            File::makeDirectory($tempPath, 0755, true);
        }

        // Extract the specific SQL file from the ZIP
        $zip = new ZipArchive;
        $sqlFilePath = null;

        if ($zip->open($backupFullPath) === true) {
            // Loop through all files in the ZIP to find a `.sql` file
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileName = $zip->getNameIndex($i);
                if (str_ends_with($fileName, '.sql')) {
                    $sqlFilePath = $fileName; // Save the SQL file path
                    break;
                }
            }

            if ($sqlFilePath) {
                // Extract the SQL file
                $zip->extractTo($tempPath, $sqlFilePath);
                $zip->close();
            } else {
                return redirect()->route('backups.index')->with('error', 'No SQL file found in the backup.');
            }
        } else {
            return redirect()->route('backups.index')->with('error', 'Failed to open the backup file.');
        }

        // Restore the database from the extracted SQL file
        $extractedSqlFilePath = $tempPath . '/' . $sqlFilePath;
        if (File::exists($extractedSqlFilePath)) {
            try {
                // Import the SQL dump into the database
                DB::unprepared(File::get($extractedSqlFilePath));
            } catch (\Exception $e) {
                return redirect()->route('backups.index')->with('error', 'Database restoration failed: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('backups.index')->with('error', 'Extracted SQL file not found.');
        }

        // Cleanup temporary directory
        File::deleteDirectory($tempPath);

        return redirect()->route('backups.index')->with('success', 'Database restored successfully.');
    }
}
