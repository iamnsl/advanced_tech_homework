"use client";

import { useRef, useState } from "react";
import { upload } from "@vercel/blob/client";
import { CODE_PATTERN, normalizeCode } from "@/lib/code";

function sanitizeFilename(name) {
  return name.replace(/[/\\]/g, "-").trim() || "file";
}

function parseFilenameFromHeader(header) {
  if (!header) return null;
  const utf8Match = header.match(/filename\*=UTF-8''([^;]+)/i);
  if (utf8Match) return decodeURIComponent(utf8Match[1]);
  const plainMatch = header.match(/filename="([^"]+)"/i);
  return plainMatch ? plainMatch[1] : null;
}

export default function Home() {
  const fileInputRef = useRef(null);

  const [file, setFile] = useState(null);
  const [uploading, setUploading] = useState(false);
  const [progress, setProgress] = useState(0);
  const [resultCode, setResultCode] = useState(null);
  const [uploadError, setUploadError] = useState(null);
  const [copied, setCopied] = useState(false);

  const [codeInput, setCodeInput] = useState("");
  const [downloading, setDownloading] = useState(false);
  const [downloadError, setDownloadError] = useState(null);
  const [downloadSuccess, setDownloadSuccess] = useState(null);

  function pickFile(selected) {
    if (!selected) return;
    setFile(selected);
    setResultCode(null);
    setUploadError(null);
  }

  async function handleUpload() {
    if (!file) return;
    setUploading(true);
    setUploadError(null);
    setResultCode(null);
    setProgress(0);

    try {
      const codeRes = await fetch("/api/code");
      const codeData = await codeRes.json();
      if (!codeRes.ok) throw new Error(codeData.error || "تعذر توليد كود");

      const code = codeData.code;
      const pathname = `transfers/${code}/${sanitizeFilename(file.name)}`;

      await upload(pathname, file, {
        access: "public",
        handleUploadUrl: "/api/upload",
        onUploadProgress: (event) => setProgress(Math.round(event.percentage)),
      });

      setResultCode(code);
    } catch (error) {
      setUploadError(error instanceof Error ? error.message : "فشل رفع الملف");
    } finally {
      setUploading(false);
    }
  }

  async function handleCopy() {
    if (!resultCode) return;
    try {
      await navigator.clipboard.writeText(resultCode);
      setCopied(true);
      setTimeout(() => setCopied(false), 1500);
    } catch {
      // clipboard may be unavailable; ignore silently
    }
  }

  async function handleDownload() {
    const code = normalizeCode(codeInput);
    setDownloadError(null);
    setDownloadSuccess(null);

    if (!CODE_PATTERN.test(code)) {
      setDownloadError("الكود يتكوّن من 6 أحرف وأرقام");
      return;
    }

    setDownloading(true);
    try {
      const res = await fetch(`/api/download/${code}`);
      if (!res.ok) {
        const data = await res.json().catch(() => ({}));
        throw new Error(data.error || "تعذر تحميل الملف");
      }

      const filename =
        parseFilenameFromHeader(res.headers.get("content-disposition")) ||
        "file";
      const blob = await res.blob();
      const url = URL.createObjectURL(blob);
      const link = document.createElement("a");
      link.href = url;
      link.download = filename;
      document.body.appendChild(link);
      link.click();
      link.remove();
      URL.revokeObjectURL(url);

      setDownloadSuccess(`تم تحميل "${filename}". هذا الكود لن يعمل مرة أخرى.`);
      setCodeInput("");
    } catch (error) {
      setDownloadError(
        error instanceof Error ? error.message : "تعذر تحميل الملف",
      );
    } finally {
      setDownloading(false);
    }
  }

  return (
    <main className="page">
      <div className="hero">
        <h1>نقل الملفات بكود لمرة واحدة</h1>
        <p>
          ارفع أي ملف (إكسل، وورد، صور...)، شارك الكود مع أي شخص على أي شبكة،
          وبمجرد تحميله يُحذف الملف تلقائيًا.
        </p>
      </div>

      <div className="grid">
        <section className="card">
          <h2>📤 إرسال ملف</h2>
          <p className="desc">اختر ملفًا واضغط إرسال للحصول على الكود</p>

          <label
            className="dropzone"
            onDragOver={(e) => e.preventDefault()}
            onDrop={(e) => {
              e.preventDefault();
              pickFile(e.dataTransfer.files?.[0]);
            }}
          >
            <input
              ref={fileInputRef}
              type="file"
              onChange={(e) => pickFile(e.target.files?.[0])}
            />
            {file ? (
              <span className="fileName">{file.name}</span>
            ) : (
              <span>اضغط هنا أو اسحب الملف وأفلته</span>
            )}
          </label>

          {uploading && (
            <div className="progress">
              <div style={{ width: `${progress}%` }} />
            </div>
          )}

          <button onClick={handleUpload} disabled={!file || uploading}>
            {uploading ? `جاري الرفع... ${progress}%` : "إرسال والحصول على كود"}
          </button>

          {uploadError && <div className="message error">{uploadError}</div>}

          {resultCode && (
            <div className="codeResult">
              <span className="hint">شارك هذا الكود مع المستلم</span>
              <span className="code">{resultCode}</span>
              <button onClick={handleCopy}>
                {copied ? "تم النسخ ✓" : "نسخ الكود"}
              </button>
              <span className="hint">
                يعمل الكود مرة واحدة فقط، ويُحذف الملف بعد أول تحميل.
              </span>
            </div>
          )}
        </section>

        <section className="card">
          <h2>📥 استلام ملف</h2>
          <p className="desc">أدخل الكود المكوّن من 6 خانات لتحميل الملف</p>

          <input
            type="text"
            maxLength={6}
            placeholder="ABCD12"
            value={codeInput}
            onChange={(e) => setCodeInput(e.target.value.toUpperCase())}
            onKeyDown={(e) => e.key === "Enter" && handleDownload()}
          />

          <button
            onClick={handleDownload}
            disabled={downloading || codeInput.length !== 6}
          >
            {downloading ? "جاري التحميل..." : "تحميل الملف"}
          </button>

          {downloadError && (
            <div className="message error">{downloadError}</div>
          )}
          {downloadSuccess && (
            <div className="message success">{downloadSuccess}</div>
          )}
        </section>
      </div>

      <p className="footer">
        الملفات تُخزَّن مؤقتًا حتى أول تحميل فقط، ولا تحتاج الشبكة نفسها للإرسال
        والاستلام.
      </p>
    </main>
  );
}
