import "./globals.css";

export const metadata = {
  title: "نقل الملفات — كود لمرة واحدة",
  description:
    "ارفع ملفك واحصل على كود، وشاركه مع أي شخص على أي شبكة ليحمّل الملف مرة واحدة فقط.",
};

export default function RootLayout({ children }) {
  return (
    <html lang="ar" dir="rtl">
      <body>{children}</body>
    </html>
  );
}
