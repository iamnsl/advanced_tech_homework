import { handleUpload } from "@vercel/blob/client";

const MAX_UPLOAD_BYTES = 200 * 1024 * 1024; // 200MB
const PATHNAME_PATTERN = /^transfers\/[A-Z0-9]{6}\/[^/]+$/;

export async function POST(request) {
  const body = await request.json();

  try {
    const jsonResponse = await handleUpload({
      body,
      request,
      onBeforeGenerateToken: async (pathname) => {
        if (!PATHNAME_PATTERN.test(pathname)) {
          throw new Error("مسار غير صالح");
        }
        return {
          addRandomSuffix: false,
          allowOverwrite: false,
          maximumSizeInBytes: MAX_UPLOAD_BYTES,
        };
      },
      onUploadCompleted: async () => {
        // Nothing to persist separately: the code lives in the blob's
        // pathname, and the download route deletes the blob after the
        // first successful download to enforce one-time use.
      },
    });

    return Response.json(jsonResponse);
  } catch (error) {
    return Response.json(
      { error: error instanceof Error ? error.message : "فشل رفع الملف" },
      { status: 400 },
    );
  }
}
