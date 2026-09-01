import { list, del } from "@vercel/blob";
import { CODE_PATTERN, normalizeCode } from "@/lib/code";

function contentDispositionFor(filename) {
  const asciiFallback = filename.replace(/[^\x20-\x7e]/g, "_");
  return `attachment; filename="${asciiFallback}"; filename*=UTF-8''${encodeURIComponent(filename)}`;
}

export async function GET(request, { params }) {
  const { code: rawCode } = await params;
  const code = normalizeCode(rawCode);

  if (!CODE_PATTERN.test(code)) {
    return Response.json({ error: "صيغة الكود غير صحيحة" }, { status: 400 });
  }

  const { blobs } = await list({ prefix: `transfers/${code}/`, limit: 1 });
  const blob = blobs[0];

  if (!blob) {
    return Response.json(
      { error: "الكود غير موجود أو تم استخدامه من قبل" },
      { status: 404 },
    );
  }

  const upstream = await fetch(blob.url);
  if (!upstream.ok || !upstream.body) {
    return Response.json({ error: "تعذر جلب الملف" }, { status: 502 });
  }

  // Delete right away so the code can never be used a second time,
  // even if the client's download stalls or fails partway through.
  await del(blob.url);

  const filename = blob.pathname.split("/").pop();

  return new Response(upstream.body, {
    headers: {
      "Content-Type": blob.contentType || "application/octet-stream",
      "Content-Disposition": contentDispositionFor(filename),
      ...(blob.size ? { "Content-Length": String(blob.size) } : {}),
    },
  });
}
